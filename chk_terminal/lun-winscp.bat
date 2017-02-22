@echo off
SET var=%cd%
rem ECHO %var%

c:
cd \
cd Program Files
cd winscp

rem Get the datetime in a format that can go in a filename.

For /f "tokens=2-4 delims=/ " %%a in ('date /t') do (set mydate=%%c-%%a-%%b)
For /f "tokens=1-2 delims=/:" %%a in ('time /t') do (set mytime=%%a%%b)

rem echo %mydate%_%mytime%

winscp.com /script=%var%\lun_sync.txt /log=%var%\log\sync_%mydate%_%mytime%.txt


echo Upload succeeded, moving local files
move %var%\ct*.txt %var%\done\
 
del %var%\chk.txt
 

rem d:\xampp\htdocs\lunari\chk_terminal\lun-winscp 