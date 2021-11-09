<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Account;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Integer;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

class Table extends PowerGridComponent
{
    use ActionButton;

    public string $primaryKey = 'users.id';
    public string $sortField = 'users.id';// Обязательно указывать первичные ключи


    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp()
    {
        $this->showCheckBox() // Отображает четбоксы
            ->showPerPage(20) // Показывает раскрывающееся меню для выбора количества строк, отображаемых на странице
            ->showRecordCount('full')// Показывает количество записей внизу страницы
            ->showExportOption('download', ['excel', 'csv']) //кнопку экспорта вверху страницы
            ->showSearchInput() // Включает функцию поиска и отображает поле ввода поиска вверху страницы
            ->showToggleColumns(); // Отображает кнопку для скрытия / отображения (переключения) столбцов

    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */
    public function datasource(): ?Builder
    {
        return User::query()->with('account')->with('hasOneAccounts')
           /* ->join('accounts','users.id','=','accounts.user_id')
            ->select('users.*' ,'accounts.name as account_name');*/
            ->join('accounts', function ($categories) {
                $categories->on('users.id', '=', 'accounts.user_id');
            })
            ->select([
                'users.id',
                'accounts.id',
                'accounts.name as account_name','users.name as name','users.email as email'
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */
    public function relationSearch(): array
    {
        return [
            'account' => ['account_name'] // В приведенном выше примере добавляется связь с kitchen моделью и разрешается nameпоиск в столбце
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    public function addColumns(): ?PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('email')
            ->addColumn('accounts')
            ->addColumn('real')
            ->addColumn('demo')
            ->addColumn('created_at_formatted', function(User $model) {
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
            })// В поле базы данных created_at хранится дата yyyy-mm-dd H:i:s
            ->addColumn('updated_at_formatted', function(User $model) {
                return Carbon::parse($model->updated_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('available', function (User $model) {
                return ($model->in_stock ? 'yes' : 'no'); // настраиваемый столбец, availableкоторый отображает «да» / «нет» в зависимости от поля базы данных in_stock(истина / ложь).
    });
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */
    public function columns(): array
    {   $canEdit = true; //User has edit permission
        $canCopy = true; //User has permission to copy
        return [
            Column::add()
                ->title(__('ID'))
                ->field('id')
                /*->toggleable($canEdit,'yes', 'no')//кнопка добавляется в каждую ячейку столбца «В наличии ».*/
               /* ->makeBooleanFilter('in_stock', 'yes', 'no')// Добавляет фильтр для логических значений*/
                ->makeInputRange(),

            Column::add()
                ->title(__('NAME'))
                ->field('name')
                ->sortable()
                ->searchable()
                ->clickToCopy($canCopy, 'Copy name to clipboard')
                ->editOnClick($canEdit) // редактирование в один клик Важно: editOnClick при нажатии требует настройки метода обновления данных .
                ->makeInputSelect(User::all(), 'name', 'name') //Включает определенное поле на страницу для фильтрации отношения hasOne в столбце
                ->makeInputText(),

            Column::add()
                ->title(__('EMAIL'))
                ->field('email')
                ->sortable()
                ->searchable()
                ->editOnClick($canEdit) // редактирование в один клик Важно: editOnClick при нажатии требует настройки метода обновления данных .
                ->makeInputText(),// Добавляет фильтр ввода текста в столбец

            Column::add()
                ->title(__('ACCOUNTS'))
                ->field('account_name')
                ->searchable()
                ->sortable()
                ->makeInputSelect(Account::all(), 'name', 'id') //Включает определенное поле на страницу для фильтрации отношения hasOne в столбце
                /*->makeInputDatePicker('updated_at')*/,

            Column::add()
                ->title(__('REAL'))
                ->field('real')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('updated_at'),

            Column::add()
                ->title(__('DEMO'))
                ->field('demo')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('updated_at'),

            Column::add()
                ->title(__('CREATED AT'))
                ->field('created_at_formatted')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('created_at'),

            Column::add()// Добавляет новый столбец в таблицу PowerGrid
                ->title(__('UPDATED AT')) // Устанавливает заполнитель для этого столбца при использовании фильтра столбца. Устанавливает заголовок в заголовке столбца
                ->field('updated_at_formatted')// Связывает столбец с существующим полем источника данных или настраиваемым столбцом
                ->searchable() // возможность поиска
                ->sortable()//Добавляет кнопку сортировки в заголовок столбца
                ->makeInputDatePicker('') //Включает определенное поле на страницу для фильтрации между определенной датой в столбце.
                ->headerAttribute('text-center', 'color:red')// добавляет классы и стили
                ->makeInputSelect(User::all(), 'state', 'kitchen_id')//Включает определенное поле на страницу для фильтрации отношения hasOne в столбце

            /*Column::add()
                ->title(__('Categoria'))
                ->field('category_name')
                ->makeInputMultiSelect(Category::all(), 'name', 'category_id')
                ->sortable('categories.name'),*/ //Если вам нужно отсортировать по столбцу, который находится в другой таблице, вы можете добавить имя таблицы вместе со столбцом. (Например, categories.name)
        ]
;
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable this section only when you have defined routes for these actions.
    |
    */


    public function actions(): array
    {
        $canClickButton = true; //User has permission to edit
       return [
           Button::add('edit')// Кнопка редактирования
               ->caption(__('Edit'))
               ->class('bg-indigo-500 text-white')
               ->route('user.edit', ['user' => 'id']),

           Button::add('destroy') // Кнопка удаления
               ->caption(__('Delete'))
               ->class('bg-red-500 text-white')
               ->route('user.destroy', ['user' => 'id'])
               ->method('delete'),

           Button::add('new-modal') // Кнопка нового окна
               ->caption('New window')
               ->class('bg-gray-300')
               ->openModal('view-dish', ['dish' => 'id'])//Открывает модальное окно
               ->method('get')
               ->route('user.destroy', ['dish' => 'id'])
               ->can($canClickButton),

           Button::add('view')
               ->caption('View')
               ->class('btn btn-primary')
               ->emit('postAdded', ['key' => 'id'])
               ->route('user.destroy', ['user' => 'id'])
               ->method('get')
               ->can($canClickButton),
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable this section to use editOnClick() or toggleable() methods
    |
    */


    public function update(array $data ): bool
    {
       try {
           $updated = User::query()->find($data['id'])->update([
                $data['field'] => $data['value']
           ]);
       } catch (QueryException $exception) {
           $updated = false;
       }
       return $updated;
    }

    public function updateMessages(string $status, string $field = '_default_message'): string
    {
        $updateMessages = [
            'success'   => [
                '_default_message' => __('Data has been updated successfully!'),
                //'custom_field' => __('Custom Field updated successfully!'),
            ],
            'error' => [
                '_default_message' => __('Error updating the data.'),
                //'custom_field' => __('Error updating custom field.'),
            ]
        ];

        return ($updateMessages[$status][$field] ?? $updateMessages[$status]['_default_message']);
    }


    public function template(): ?string
    {
        return null;
    }

}
