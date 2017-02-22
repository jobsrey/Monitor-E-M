 

#NoEnv  ; Recommended for performance and compatibility with future AutoHotkey releases.
SendMode Input  ; Recommended for new scripts due to its superior speed and reliability.
SetWorkingDir %A_ScriptDir%  ; Ensures a consistent starting directory.
 
  tFIle = selectedfile.txt  
  Loop
  {
    FileReadLine, line, %tFIle%, %A_Index%
    src = %line%
    if ErrorLevel
        break
  }

   ;MsgBox, %src%

   FileCopy, %src%, t:/videocopy/

