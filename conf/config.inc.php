<?
 ########################################################################
 #                                                                      #
 # "EPP Ceglia Tools" - version 0.9                                     #
 # Useful Functions and Tools for EPP Registrar Operations              #
 #                                                                      #
 # Copyright (C) 2009 - 2010 by Giovanni Ceglia                         #
 #                                                                      #
 # This file is part of "EPP Ceglia Tools".                             #
 #                                                                      #
 # "EPP Ceglia Tools" is free software: you can redistribute it and/or  #
 # modify it under the terms of the GNU General Public License as       # 
 # published by the Free Software Foundation, either version 3 of the   #
 # License, or (at your option) any later version.                      #
 #                                                                      #
 # This program is distributed in the hope that it will be useful,      #
 # but WITHOUT ANY WARRANTY; without even the implied warranty of       # 
 # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the         #
 # GNU General Public License for more details.                         #
 #                                                                      #
 # You should have received a copy of the GNU General Public License    #
 # along with this program. If not, see <http://www.gnu.org/licenses/>. #
 #                                                                      #
 ########################################################################

 ########################################################################
 #                                                                      #
 # This software is available at http://www.giovanniceglia.com          #
 # Comments and suggestions: http://www.giovanniceglia.com              #
 #                                                                      #
 # All contact info to contact Ceglia Giovanni can be found on:         # 
 # http://www.ceglia.tel, you can also write:                           #
 # giovanni.ceglia@gmail.com or giovanniceglia@xungame.com              #
 #                                                                      #
 ########################################################################

 global $epp_server, $epp_port, $epp_prot, $epp_ssl, $tld_dir, $epp_timeout, $epp_clTRID;
 global $epp_clientname, $epp_clienthost, $epp_username, $epp_password, $epp_professional;;
 global $epp_opensession, $epp_SESSIONID, $epp_http, $tcp_perm, $epp_keepalive;
 global $epp_postemail_to, $epp_postemail_from, $epp_postemail_active, $EPP_CRYPTKEY;
 global $EPP_NOCRYPT, $epp_postemail_polling_notify, $epp_cms_debug, $epp_xml_path;
 global $EPP_OPCODES_PROCESSING;

 ##########################################################################
 # Dati per configurare modulo.                                           #
 ##########################################################################
 #                                                                        #
 # epp_prot sta per Protocollo, i valori consentiti sono:                 #
 #                                                                        #
 # TCP(EPP Over TCP), HTTP(EPP Over HTTP), SMTP(EPP Over SMTP)            #
 #                                                                        #
 # epp_ssl indica se si desidera usare SSL, valori possibili TRUE o FALSE #
 #                                                                        #
 # epp_http indica se le richieste http devono chiudere la connessione    #
 # o meno, dopo la richiesta, i valori possibili sono CLOSE, PERMANENT    #
 # si consiglia di impostare su PERMANENT.                                #
 #                                                                        #
 ##########################################################################

 $epp_server="epp.nic.it";

 $epp_prot="HTTP";
 $epp_port=443;
 $epp_ssl=TRUE;
 $epp_http="PERMANENT";
 $tcp_perm="PERMANENT";
 
 $epp_clTRID="1234-9EURO";

 $epp_username_A="XXXXX-REG";
 $epp_password_A="xxxxxxxx";

 $epp_username_B=$epp_username_A;
 $epp_password_B=$epp_password_A;

 $epp_username=$epp_username_A;
 $epp_password=$epp_password_A;

 $tld_dir="IT";

 $epp_timeout=60;
 $epp_keepalive=500;

 $epp_clientname="EPP XXX-REG Client";
 $epp_clienthost="epp.9euro.com";

 $epp_opensession=FALSE;
 $epp_SESSIONID="";

 ##########################################################################
 # Se si desidera copia dei Post XML via E-Mail, utile in fase di test.   #
 # *** Nota Importante *** ricevere le notifiche dei post EPP via e-mail  #
 # è molto pericolo e rende vulnerabili agli attacchi "Man in the Middle" #
 # Usare queste opzioni solo per necessità di debug, disattivare queste   #
 # notifiche in fase di produzione.                                       #
 ##########################################################################
 
 $epp_postemail_to="fax@9euro.com";
 $epp_postemail_from="Giovanni Ceglia<webmaster@9euro.com>";
 $epp_postemail_active=FALSE;

 ##########################################################################
 # Se si desiderano le notifiche dei messaggi di polling, mettere la      #
 # la variabile sotto a TRUE ed impostare i paramentri epp_postemail_to   #
 # e epp_postemail_from                                                   #
 ##########################################################################

 $epp_postemail_polling_notify=TRUE;

 ##########################################################################
 # Opzione da tenere su FALSE se si usa la versione gratuita di questo    #
 # pacchetto, per maggiori informazioni sulle versioni a pagamento più    #
 # avanzate, con pannello proprietario per domini, gestione back orders,  # 
 # sistema di gestione ordini, fatture pagamento, con supporto per        #
 # BankPass, Banca Sella, PayPal, ed i metodi tradizionali, automail      #
 # per avvisi vari, ed avvisi di scadenze domini, tools di sicurezza      #
 # AntiRootKit, AntiSpam Proprietario, WebMail Proprietaria,              #
 # interfacciamento con i maggiori whois, interfacciamento con Apache,    #
 # IIS, FileZilla Server, e molte altre possibilità, è possibile          #
 # contattare Ceglia Giovanni per un preventivo.                          #
 ##########################################################################

 $epp_professional=TRUE;

 ##########################################################################
 # Modificare la seguente chiave con una propria, sono ammessi tutti i    #
 # caratteri alfanumerici, questa chiave verrà utilizzata dallo script    # 
 # per codificare e decodificare gli auth-info e le varie password.       #
 # Tramite questa codifica delle password, si è al riparo da un eventuale #
 # furto del database, naturalmente è meglio tenere script e chiave su    #
 # server diversi, in modo da evitare il furto di entrambi.               #
 #                                                                        #
 # Nota Importante: Durante il primo setup, impostare come "" vuota la    #
 # chiave sottostante, quindi dal pannello andare in Password Pannello    #
 # inserire la chiave nuova che si dovrà copiare qui, ed inserire come    #
 # vecchia chiave una chiave vuota "", fare l'operazione di cambio chiave #
 # e quindi inserire la nuova chiave nella variabile sottostante,         #
 # la chiave in questo file è un esempio di come può essere una chiave    #
 ##########################################################################

 $EPP_CRYPTKEY="oz93dj48sh290Slz03Zdj20d92kZQ23X532ys30D492dl23n052mxs302";

 ##########################################################################
 # Se si desidera disabilitare la codifica/decodifica password nel db,    # 
 # impostare la variabile sottostante EPP_NOCRYPT a TRUE, se invece si    #
 # vuole usufruire di questa maggiore sicurezza, impostarla a FALSE       #
 ##########################################################################

 $EPP_NOCRYPT=TRUE;

 ##########################################################################
 # Se si vuole usare un certificato SSL specifico, è possibile farlo      #
 # impostando l'utilizzo di CURL, questo metodo userà il certificato      #
 # specificato e CURL come mezzo per inviare le richieste via HTTPs       #
 ##########################################################################

 global $epp_usecurl, $epp_sslcert, $epp_sslcert_file, $epp_sslcert_privatekey, $epp_sslcert_keypassword;
 global $epp_curl_session_logs;

 $epp_usecurl=FALSE;
 $epp_sslcert=FALSE;
 $epp_sslcert_file="";
 $epp_sslcert_privatekey="";
 $epp_sslcert_keypassword="";

 $epp_curl_session_logs="/var/www/php/tmp";

 ##########################################################################
 # Se si vuole usare un certificato SSL specifico, è possibile farlo      #
 # impostando i parametri sottostanti per OpenSSL, lasciare bianchi i     #
 # parametri che si vogliono ignorare                                     #
 ##########################################################################

 global $epp_openssl_cert, $epp_openssl_conf, $epp_openssl_expiring, $epp_openssl_passphrase, $epp_openssl_pubkey;

 $epp_openssl_cert=FALSE;
 $epp_openssl_conf="";
 $epp_openssl_expiring="";
 $epp_openssl_passphrase="";
 $epp_openssl_pubkey="";

 ##########################################################################
 # Impostazioni valori di default per alcuni form nel pannello ed altre   #
 # nuove funzionalità aggiuntive o che verranno aggiunte in futuro        #
 ##########################################################################

 global $DEFAULT_COUNTRY_CODE,$DEFAULT_COUNTRY_TELPREFIX,$epp_allowed_ip,$epp_log_confirm,$epp_contactid_lenght;

 $DEFAULT_COUNTRY_CODE="IT";
 $DEFAULT_COUNTRY_TELPREFIX="+39";

 $epp_allowed_ip=""; 
 $epp_log_confirm=FALSE;

 $epp_contactid_lenght=16;

 ##########################################################################
 # Variabili utilizzate in libreria di supporto a Plug-in nei CMS comuni  #
 ##########################################################################

 $epp_cms_debug=FALSE;
 $epp_xml_path="";

 ##########################################################################
 # Nuovi Parametri per Varianti di EPP Over TCP e per IP Binding          #
 ##########################################################################

 global $TCP_OPEN_HANDSHAKE, $TCP_IP_BINDING;
 
 $TCP_OPEN_HANDSHAKE=FALSE;
 $TCP_IP_BINDING="";

 ##########################################################################
 # Nuovi Parametri per Collegamento a pannelli o sistemi esterni          #
 ##########################################################################

 global $EXTERNAL_CALLS_ACTIVE;

 $EXTERNAL_CALLS_ACTIVE=FALSE;

 ##########################################################################
 # Nuovi Parametri 2014                                                   #
 ##########################################################################

 $EPP_OPCODES_PROCESSING=TRUE;

 ##########################################################################
 # Nuove Variabili Aggiunge nel 2016                                      #
 ##########################################################################
  
 global $USE_DEFAULT_ADMREG; 

 $USE_DEFAULT_ADMREG=TRUE;

 ##########################################################################
 # Nuove Variabili Aggiunge nel 2024                                      #
 ##########################################################################

 global $SHOW_SUGGESTED_LINK, $SHOW_DEBUG_PHPINFO, $SHOW_EXAM_LINKS; 

 $SHOW_SUGGESTED_LINK=TRUE;
 $SHOW_DEBUG_PHPINFO=TRUE;

?>
