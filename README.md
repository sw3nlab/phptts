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

### Установка
Debian / Raspbian
```bash
#!!! Это Предварительная версия мана по установке! ВОЗМОЖНО ОТСУТСТВИЕ НЕКОТОРЫХ ПАКЕТОВ !
sudo apt-get update
sudo apt-get install apache2 php5 git madplay
sudo usermod -a -G audio www-data
sudo service apache2 restart
cd /var/www/html/
git clone https://github.com/sw3nlab/phptts.git
cd phptts/
chmod 777 *.txt
```

OpenWRT / LEDE
```bash
#!!! Это Предварительная версия мана по установке! ВОЗМОЖНО ОТСУТСТВИЕ НЕКОТОРЫХ ПАКЕТОВ !
opkg update
opkg install kmod-usb-audio php7-cgi madplay git-http ca-bundle
cd /www/
git clone https://github.com/sw3nlab/phptts.git
cd phptts/
chmod 777 *.txt
```
Итого: ~10Mb Свободного места на flash роутера.

