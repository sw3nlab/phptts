### phptts 
( простой скрипт синтеза речи использующий wget,madplay и общедоступный функционал google tts ) 

Text to speech realisation on php and google tts


### Минимальные системные требования )
>
+ любое Linux окружение с поднятым web-сервером и интерпритатором языка php 
(может работать как на роутерах с предустановленой прошивкой OpenWRT c необходимыми модулями ядра для работы с внешней звуковой картой!!!
так и на одноплатных микрокомпьютерах типа Raspberry Pi) 
+ Наличие на сервере утилит `wget` и `madplay` (вместо `madplay` можно попробовать `aplay` или `vlc`)
+ Разрешения вебсерверу на работу со звуковыми устройствами `sudo usermod -a -G audio www-data` 

### Необходимые железяки
> Встроеная или внешняя USB звуковая плата + колонки или наушники =)
