<?php return array (
  'backpack/backupmanager' => 
  array (
    'providers' => 
    array (
      0 => 'Backpack\\BackupManager\\BackupManagerServiceProvider',
    ),
  ),
  'backpack/crud' => 
  array (
    'providers' => 
    array (
      0 => 'Backpack\\CRUD\\BackpackServiceProvider',
    ),
    'aliases' => 
    array (
      'CRUD' => 'Backpack\\CRUD\\app\\Library\\CrudPanel\\CrudPanelFacade',
      'Widget' => 'Backpack\\CRUD\\app\\Library\\Widget',
    ),
  ),
  'barryvdh/laravel-dompdf' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\DomPDF\\ServiceProvider',
    ),
    'aliases' => 
    array (
      'PDF' => 'Barryvdh\\DomPDF\\Facade',
    ),
  ),
  'barryvdh/laravel-ide-helper' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\LaravelIdeHelper\\IdeHelperServiceProvider',
    ),
  ),
  'creativeorange/gravatar' => 
  array (
    'providers' => 
    array (
      0 => 'Creativeorange\\Gravatar\\GravatarServiceProvider',
    ),
    'aliases' => 
    array (
      'Gravatar' => 'Creativeorange\\Gravatar\\Facades\\Gravatar',
    ),
  ),
  'digitallyhappy/assets' => 
  array (
    'providers' => 
    array (
      0 => 'DigitallyHappy\\Assets\\AssetsServiceProvider',
    ),
    'aliases' => 
    array (
      'Assets' => 'DigitallyHappy\\Assets\\Facades\\Assets',
    ),
  ),
  'facade/ignition' => 
  array (
    'providers' => 
    array (
      0 => 'Facade\\Ignition\\IgnitionServiceProvider',
    ),
    'aliases' => 
    array (
      'Flare' => 'Facade\\Ignition\\Facades\\Flare',
    ),
  ),
  'fideloper/proxy' => 
  array (
    'providers' => 
    array (
      0 => 'Fideloper\\Proxy\\TrustedProxyServiceProvider',
    ),
  ),
  'fruitcake/laravel-cors' => 
  array (
    'providers' => 
    array (
      0 => 'Fruitcake\\Cors\\CorsServiceProvider',
    ),
  ),
  'laravel/breeze' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Breeze\\BreezeServiceProvider',
    ),
  ),
  'laravel/sail' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Sail\\SailServiceProvider',
    ),
  ),
  'laravel/sanctum' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Sanctum\\SanctumServiceProvider',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'livewire/livewire' => 
  array (
    'providers' => 
    array (
      0 => 'Livewire\\LivewireServiceProvider',
    ),
    'aliases' => 
    array (
      'Livewire' => 'Livewire\\Livewire',
    ),
  ),
  'nesbot/carbon' => 
  array (
    'providers' => 
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'nunomaduro/collision' => 
  array (
    'providers' => 
    array (
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ),
  ),
  'prologue/alerts' => 
  array (
    'providers' => 
    array (
      0 => 'Prologue\\Alerts\\AlertsServiceProvider',
    ),
    'aliases' => 
    array (
      'Alert' => 'Prologue\\Alerts\\Facades\\Alert',
    ),
  ),
  'spatie/laravel-backup' => 
  array (
    'providers' => 
    array (
      0 => 'Spatie\\Backup\\BackupServiceProvider',
    ),
  ),
  'spatie/laravel-permission' => 
  array (
    'providers' => 
    array (
      0 => 'Spatie\\Permission\\PermissionServiceProvider',
    ),
  ),
);