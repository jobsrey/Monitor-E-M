;
; AutoHotkey Version: 1.x
; Language:       English
; Platform:       Win9x/NT
; Author:         A.N.Other <myemail@nowhere.com>
;
; Script Function:
;	Template script (you can customize this template by editing "ShellNew\Template.ahk" in your Windows folder)
;

#NoEnv  ; Recommended for performance and compatibility with future AutoHotkey releases.
SendMode Input  ; Recommended for new scripts due to its superior speed and reliability.
SetWorkingDir %A_ScriptDir%  ; Ensures a consistent starting directory.

#Include settime.cfg 

Loop ; 
{ 
  

  ;MsgBox,,, Check Terminal Processing... ,5
  
  ;open chk.txt
  FileRead, Contents,  %A_ScriptDir%\chk.txt 
  ;MsgBox, %Contents% 


  if( Contents = 1){ 
	
    MsgBox,,, Sync data www...,2
    run %A_ScriptDir%\lun-winscp.bat
  
    Sleep, %waittime%

    MsgBox,,, Done...,5

  }else{ 

    FileDelete,	%A_ScriptDir%\chk.txt 

    MsgBox,,, Begin Checking Terminals... ,1
    run %A_ScriptDir%\lun-ct.bat

    MsgBox,,, waittime : %waittime% ... ,2
    Sleep, %waittime%

  }

  

}