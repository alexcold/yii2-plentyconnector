## Info

Extension Version: 0.3v

## Configuration

Add to you modules config file these lines :

modules => [
    'plenty' => [
        'class' => 'alexcold\plentyconnector\PlentySoapApi'
    ]
],

## Migrations

type this code into the terminal to migrate : $ php yii migrate/up --migrationPath=@vendor/alexcold/yii2-plentyconnector/migrations