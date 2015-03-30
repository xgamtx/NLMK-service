update nlmkService.carriage set storage = 7 where storage = 'МАЛЬЧИКИ';
update nlmkService.carriage set storage = 8 where storage = 'ПЕРСПЕКТИВНАЯ';
update nlmkService.carriage set storage = 1 where storage = 'Ворсино';

alter table nlmkService.carriage modify storage int;