<?php

namespace App\DataTables;

use App\Models\Album;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AlbumsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', 'albums.action')
            ->addColumn('update', function(Album $album) {
                return '<a href='.'/albums/'.$album->id.'/edit'.' class="btn btn-dange"><i class="bi bi-gear-wide-connected"></i></a>';
            })
            ->addColumn('delete', function(Album $album) {
                return '<a href='.'/albums/'.$album->id.'/check-delete'.' class="btn btn-dange "><i class="bi bi-archive"></i></a>';
            })
            ->rawColumns(['update','delete']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Album $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Album $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('albums-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                   ->orderBy(1);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'name',
            'update',
            'delete',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */

    protected function filename(): string
    {
        return 'Albums_'.date('YmdHis');
    }
}
