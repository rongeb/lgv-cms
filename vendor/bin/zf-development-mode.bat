@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../zfcampus/zf-development-mode/bin/zf-development-mode
php "%BIN_TARGET%" %*
