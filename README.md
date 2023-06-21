# DataTableHandler-VP

## Installation
Run
```composer require netvibes/publicerrormessage```


Add to handler.php 
```php
    use Netvibes\Publicerrormessage\PublicErrorMessageService;


    public function render($request, Throwable $exception)
    {
        if (!config('app.debug')){
            $ErrrorResponse = PublicErrorMessageService::processErrors($request, $exception);
            if ($ErrrorResponse) {
                return $ErrrorResponse;
            }
        }

        return parent::render($request, $exception);
    }
```

