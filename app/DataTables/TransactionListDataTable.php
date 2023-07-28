<?php

namespace App\DataTables;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TransactionListDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->setRowData([
                'data-user' => function ($transaction) {
                    return User::where('id', $transaction->user_id)->first()->email;
                },
                'data-book' => function ($transaction) {
                    return Book::where('id', $transaction->book_id)->first()->title;
                }
            ]);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Transaction $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('transactionlist-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('user_id')
                ->title('User Email')
                ->data('DT_RowData.data-user'),
            Column::make('book_id')
                ->title('Book Title')
                ->data('DT_RowData.data-book'),
            Column::make('tanggal_pinjam')
                ->title('Tanggal Pinjam'),
            Column::make('tanggal_kembali')
                ->title('Tanggal Kembali'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'TransactionList_' . date('YmdHis');
    }
}
