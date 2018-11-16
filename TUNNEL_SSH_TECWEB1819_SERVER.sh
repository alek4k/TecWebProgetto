#!/bin/bash
echo '************************************'
echo '** TUNNEL SSH SERVER TECWEB 18-19 **'
echo '************************************'
read -p 'Username lab: ' user
echo '************************************'
echo Insert password lab and get your tools:
echo phpMyAdmin: http://localhost:20080/phpmyadmin/
echo Home page personale: http://localhost:20080/$user
echo FileZilla settings: Protocollo:SFTP, Host:localhost, Porta:20022, Accesso:Normale, Utente:$user, Password: password del lab
echo SSH server tecweb su terminale locale: ssh localhost -p 20022 -l $user
echo SSH server tecweb su questo terminale: ssh tecweb1819
echo '************************************'
ssh -L23306:tecweb1819:3306 -L20443:tecweb1819:443 -L20080:tecweb1819:80 -L20022:tecweb1819:22 $user@ssh.studenti.math.unipd.it

