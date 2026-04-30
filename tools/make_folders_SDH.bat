@echo off

set PROJECT="SDH"


mkdir "%PROJECT%"
cd "%PROJECT%"

mkdir css js pages data include bilder test tools classes admin

cd admin
mkdir css js pages data include bilder test tools classes

echo Projektstruktur erstellt: %PROJECT%