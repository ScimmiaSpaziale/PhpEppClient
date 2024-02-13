<?
 #ini_set('display_errors', 1); 
 #ini_set('display_startup_errors', 1); 
 #error_reporting(E_ALL);

 global $EPPERR,$EPPREA,$EPPGEN,$TEST_STEPS,$LANGUAGE,$LANG_DIR;
 header('Content-Type: text/html; charset=iso-8859-1');

 ##############################################################################
 # Generic Error Meaning
 ##############################################################################

 $LANG_DIR="it";

 $EPPGEN[1]="Unknown Error";
 $EPPGEN[1000]="Good";
 $EPPGEN[4000]="Generic";
 $EPPGEN[5000]="Session";
 $EPPGEN[6000]="Account";
 $EPPGEN[7000]="Domain Name Server";
 $EPPGEN[8000]="Contact";
 $EPPGEN[9000]="Domain";

 ##############################################################################
 # Errors
 ##############################################################################

 $EPPERR[1000]="Command completed successfully";
 $EPPERR[1001]="Command completed successfully; action pending";
 $EPPERR[1300]="Command completed successfully; no messages";
 $EPPERR[1301]="Command completed successfully; ack to dequeue";
 $EPPERR[1500]="Command completed successfully; ending session";
 $EPPERR[2001]="Command syntax error";
 $EPPERR[2002]="Command use error";
 $EPPERR[2003]="Required parameter missing";
 $EPPERR[2004]="Parameter value range error";
 $EPPERR[2005]="Parameter value syntax error";
 $EPPERR[2100]="Unimplemented protocol version";
 $EPPERR[2101]="Unimplemented command";
 $EPPERR[2102]="Unimplemented option";
 $EPPERR[2103]="Unimplemented extension";
 $EPPERR[2104]="Billing failure";
 $EPPERR[2106]="Object is not eligible for transfer";
 $EPPERR[2200]="Authentication error";
 $EPPERR[2201]="Authorization error";
 $EPPERR[2202]="Invalid authorization information";
 $EPPERR[2300]="Object pending transfer";
 $EPPERR[2301]="Object not pending transfer";
 $EPPERR[2302]="Object exists";
 $EPPERR[2303]="Object does not exist";
 $EPPERR[2304]="Object status prohibits operation";
 $EPPERR[2305]="Object association prohibits operation";
 $EPPERR[2306]="Parameter value policy error";
 $EPPERR[2308]="Data management policy violation";
 $EPPERR[2400]="Command failed";
 $EPPERR[2500]="Command failed; server ending session";
 $EPPERR[2502]="Session limit exceeded; server closing connection";

 ##############################################################################
 # Reasons
 ##############################################################################

 $EPPREA[4003]="Syntax error";
 $EPPREA[4015]="First request on a new session was not Login";
 $EPPREA[5001]="Message ID missing";
 $EPPREA[8004]="There is nothing to update";
 $EPPREA[8019]="Email address missing";
 $EPPREA[8022]="Voice number missing";
 $EPPREA[8023]="Registrant: entity type missing";
 $EPPREA[8024]="Registrant: invalid entity type";
 $EPPREA[8025]="Registrant: nationality code missing";
 $EPPREA[8026]="Registrant: reg code missing";
 $EPPREA[8027]="Registrant: invalid reg code";
 $EPPREA[8032]="Postal information missing";
 $EPPREA[8033]="Postal information in locale form contains characters that are not allowed";
 $EPPREA[8034]="Postal information: name missing";
 $EPPREA[8035]="Postal information: org missing";
 $EPPREA[8036]="Postal information: addr missing";
 $EPPREA[8037]="Postal information: street missing";
 $EPPREA[8039]="Postal information: city missing";
 $EPPREA[8040]="Postal information: sp missing";
 $EPPREA[8041]="Postal information: pc missing";
 $EPPREA[8042]="Postal information: cc missing";
 $EPPREA[8061]="Contact: add element is empty";
 $EPPREA[8062]="Contact: rem element is empty";
 $EPPREA[8063]="Contact: chg element is empty";
 $EPPREA[9016]="Registrant missing";
 $EPPREA[9019]="There is nothing to update";
 $EPPREA[9038]="Domain: add element is empty";
 $EPPREA[9039]="Domain: rem element is empty";
 $EPPREA[9040]="Domain: chg element is empty";

 $EPPREA[8012]="Status to add has not  < client > prefix";
 $EPPREA[8013]="Status to remove has not < client > prefix";
 $EPPREA[8021]="Too many contact identifiers";
 $EPPREA[8046]="Email cannot be changed with an empty value";
 $EPPREA[8047]="Voice cannot be changed with an empty value";
 $EPPREA[8048]="Postal information: invalid cc value";
 $EPPREA[8049]="Postal information: invalid sp value";
 $EPPREA[8050]="Registrant: invalid nationality code";
 $EPPREA[8051]="Registrant: nationality code is not allowed";
 $EPPREA[8055]="Contact ID too long";
 $EPPREA[8059]="Contact status is not implemented by the server";
 $EPPREA[9003]="Contact does not exist";
 $EPPREA[9030]="Status to add has not < client > prefix";
 $EPPREA[9031]="Status to remove has not < client > prefix";
 $EPPREA[9049]="Invalid length of authInfo element";
 $EPPREA[9050]="Too many domain names";
 $EPPREA[9067]="New authorization information is current authorization information";
 $EPPREA[9073]="Domain status is not implemented by the server";

 $EPPREA[7001]="Host name syntax error";
 $EPPREA[7003]="IP address syntax error";
 $EPPREA[8018]="Email address syntax error";
 $EPPREA[8053]="Voice number syntax error";
 $EPPREA[8054]="Fax number syntax error";
 $EPPREA[9007]="Domain name syntax error";
 $EPPREA[9020]="Unsupported transfer option";
 $EPPREA[5054]="Low credit: only auto renew and unbillable commands will be processed";
 $EPPREA[5055]="Out of funds";
 $EPPREA[9018]="Destination client of the transfer operation is the domain sponsoring client";

 $EPPREA[6005]="Invalid username or password";
 $EPPREA[6006]="Login command failed";
 $EPPREA[6007]="Account disabled";
 $EPPREA[6001]="Lack of permissions to process command";
 $EPPREA[9051]="Lack of permissions to view status of domain transfer request";
 $EPPREA[9053]="Lack of permissions to cancel domain transfer request";
 $EPPREA[9071]="Lack of permissions to approve domain transfer request";
 $EPPREA[9072]="Lack of permissions to reject domain transfer request";
 $EPPREA[9001]="Authorization information missing";
 $EPPREA[9002]="Invalid domain authorization information";

 $EPPREA[9054]="Domain transfer not pending";
 $EPPREA[8058]="Contact already exists";
 $EPPREA[9017]="Domain name already exists";
 $EPPREA[5004]="There are no messages in the queue";
 $EPPREA[9003]="Contact does not exist";
 $EPPREA[9036]="Domain does not exist";

 $EPPREA[8006]="Contact has status clientDeleteProhibited";
 $EPPREA[8007]="Contact has status serverDeleteProhibited";
 $EPPREA[8008]="Contact has status clientUpdateProhibited";
 $EPPREA[8009]="Contact has status serverUpdateProhibited";

 $EPPREA[9022]="Domain has status clientTransferProhibited";
 $EPPREA[9023]="Domain has status serverTransferProhibited";
 $EPPREA[9024]="Domain has status clientDeleteProhibited";
 $EPPREA[9025]="Domain has status serverDeleteProhibited";
 $EPPREA[9026]="Domain has status clientUpdateProhibited";
 $EPPREA[9027]="Domain has status serverUpdateProhibited";
 $EPPREA[9045]="Domain has status clientHold";
 $EPPREA[9047]="Domain has status serverHold";
 $EPPREA[9055]="Domain has status ok";
 $EPPREA[9056]="Domain has status inactive";
 $EPPREA[9057]="Domain has status dnsHold";
 $EPPREA[9058]="Domain has status autoRenewPeriod";
 $EPPREA[9059]="Domain has status pendingUpdate";
 $EPPREA[9060]="Domain has status pendingTransfer";
 $EPPREA[9061]="Domain has status noRegistrar";
 $EPPREA[9062]="Domain has status toBeReassigned";
 $EPPREA[9063]="Domain has status challenged";
 $EPPREA[9064]="Domain has status redemptionPeriod";
 $EPPREA[9064]="Domain has status serverHold";
 $EPPREA[9065]="Domain has status revoked";
 $EPPREA[9066]="Domain has status pendingDelete";

 $EPPREA[8005]="Contact is associated with domains";
 $EPPREA[5002]="Message ID is not allowed";
 $EPPREA[5003]="Message ID is not the ID of the first message in the queue";
 $EPPREA[7002]="Duplicate IP addresses";
 $EPPREA[7008]="IP address to add already exists";
 $EPPREA[8001]="Contact ID syntax error";
 $EPPREA[8002]="Contact ID prefix not allowed";
 $EPPREA[8010]="Duplicate statuses to add";
 $EPPREA[8011]="Duplicate statuses to remove";
 $EPPREA[8017]="Too many postal information elements in localized form";
 $EPPREA[8020]="Consent for publishing missing";
 $EPPREA[8028]="Registrant: country code and nationality code are different";
 $EPPREA[8031]="Postal information in international form is not allowed";
 $EPPREA[8043]="Postal information: name cannot be changed for a registrant with the entity type = 1";
 $EPPREA[8044]="Postal information: org cannot be changed for a registrant";
 $EPPREA[8045]="Postal information: cc cannot be changed for a registrant with the entity type <> 1";
 $EPPREA[8056]="Registrant: contact already present as registrant - update is prohibited";
 $EPPREA[8057]="Registrant: registrant with the entity type = 1 org and name are different";
 $EPPREA[8060]="Registrant: registrant cannot be a minor";
 $EPPREA[9004]="Duplicate names of name server";
 $EPPREA[9008]="Zone is not managed by the system";
 $EPPREA[9009]="New registrant ID is current registrant ID";
 $EPPREA[9021]="Domain is reserved";
 $EPPREA[9037]="Duplicate contacts";
 $EPPREA[9043]="Domain is unassignable";
 $EPPREA[9044]="Superordinate domain is not geographic";
 $EPPREA[9052]="Transfer period is not allowed";
 $EPPREA[9075]="Duplicate statuses to add";
 $EPPREA[9076]="Duplicate statuses to remove";

 $EPPREA[5050]="Command limit exceeded";
 $EPPREA[7005]="Too few IP addresses";
 $EPPREA[7006]="Too many IP addresses";
 $EPPREA[7007]="At least one v4 IP address for this host is required";
 $EPPREA[8014]="Status to add is already associated with the contact";
 $EPPREA[8015]="Status to remove is not associated with the contact";
 $EPPREA[8029]="Registrant: registrant with the entity type = 1 and admin are different";
 $EPPREA[8030]="Contact is not a registrant";
 $EPPREA[8038]="Postal information: too many streets";
 $EPPREA[8050]="Contact is not sponsored by the registrar";
 $EPPREA[9005]="Too few name servers";
 $EPPREA[9006]="Too many name servers";
 $EPPREA[9010]="At least one administrative contact is required";
 $EPPREA[9011]="Too few administrative contacts";
 $EPPREA[9012]="Too many administrative contacts";
 $EPPREA[9013]="At least one tech contact is required";
 $EPPREA[9014]="Too few technical contacts";
 $EPPREA[9015]="Too many technical contacts";
 $EPPREA[9028]="Contact to add is already associated with the domain";
 $EPPREA[9029]="Contact to remove is not associated with the domain";
 $EPPREA[9032]="Status to add is already associated with the domain";
 $EPPREA[9033]="Status to remove is not associated with the domain";
 $EPPREA[9034]="Name server to add is already associated with the domain";
 $EPPREA[9035]="Name server to remove is not associated with the domain";
 $EPPREA[9041]="Update domain combination of status, name server and registrant is not allowed";
 $EPPREA[9048]="Name server to add is subordinatefor the domain but has no IP addresses";
 $EPPREA[9068]="Authorization information missing in update domain";
 $EPPREA[9070]="Billing contacts prohibited";
 $EPPREA[9074]="At least two name servers arerequired";

 $EPPREA[4000]="Database error";
 $EPPREA[4001]="Concurrency error";
 $EPPREA[5051]="Session opened limit exceeded";
 $EPPREA[5052]="User IP address is not allowed";

 $EPPREA[4017]="No description";
 $EPPREA[8009]="No description";
 $EPPREA[6009]="No description";

 ##############################################################################
 # Exam
 ##############################################################################
 
 $TEST_STEPS[1]="Handshake";
 $TEST_STEPS[2]="Autenticazione";
 $TEST_STEPS[3]="Modifica della password";
 $TEST_STEPS[4]="Interrogazione della coda di polling";
 $TEST_STEPS[5]="Controllo disponibilità identificatori contatti";
 $TEST_STEPS[6]="Creazione 3 contatti registrant";
 $TEST_STEPS[7]="Creazione di 2 contatti tech/admin";
 $TEST_STEPS[8]="Aggiornamento di un contatto";
 $TEST_STEPS[9]="Visualizzazione di un contatto";
 $TEST_STEPS[10]="Verifica disponibilità 2 nomi a dominio";
 $TEST_STEPS[11]="Creazione di due nomi a dominio";
 $TEST_STEPS[12]="Visualizzazione delle info di un nome a dominio";
 $TEST_STEPS[13]="Modifica di un nome a dominio";
 $TEST_STEPS[14]="Modifica Registrante nome a dominio";
 $TEST_STEPS[15]="Autenticazione tramite secondo account";
 $TEST_STEPS[16]="Richiesta di modifica Registrar di nome a dominio";
 $TEST_STEPS[17]="Approvazione della richiesta di modifica Registrar ed pulizia coda di polling";
 $TEST_STEPS[18]="Modifica dell'authinfo di un nome a dominio";
 $TEST_STEPS[19]="Richiesta di modifica Registrante contestuale a modifica Registrar";
 $TEST_STEPS[20]="Approvazione della richiesta di modifica Registrante e Registrar";
 $TEST_STEPS[21]="Aggiunta e rimozione di vincolo su nome a dominio e vis. dati del nome";
 $TEST_STEPS[22]="Cancellazione di un nome a dominio";
 $TEST_STEPS[23]="Ripristino di un nome a dominio";
 $TEST_STEPS[24]="Cancellazione di un contatto e verifica della disponibilità di un contactID";
 $TEST_STEPS[25]="ClientA-REG: verifica della coda di polling, e conservazione ID Messaggio";
 $TEST_STEPS[26]="ClientA-REG: approvazione trasferimento dominio";
 $TEST_STEPS[27]="ClientA-REG: cancellazione messaggio dalla coda di polling";
 $TEST_STEPS[28]="ClientA-REG: verifica della coda di polling, e conservazione ID Messaggio";
 $TEST_STEPS[29]="ClientA-REG: cancellazione messaggio dalla coda di polling";
 $TEST_STEPS[30]="Crea Registrant 1";
 $TEST_STEPS[31]="Crea Registrant 2";
 $TEST_STEPS[32]="Crea Registrant 3";
 $TEST_STEPS[33]="Crea Admin 1";
 $TEST_STEPS[34]="Crea Admin 2";
 $TEST_STEPS[35]="ClientB-REG: creazione di nuovo contatto registrante HH100";
 $TEST_STEPS[36]="ClientB-REG: avvio cambio registrar e registrante per dominio test-one.it";
 $TEST_STEPS[37]="Registrazione Dominio 1";
 $TEST_STEPS[38]="Registrazione Dominio 2";
 $TEST_STEPS[39]="Aggiunta di Vincolo";
 $TEST_STEPS[40]="Rimozione di Vincolo";
 $TEST_STEPS[41]="Cancellazione di un Contatto";
 $TEST_STEPS[42]="Verifica di un Contatto";
 $TEST_STEPS[43]="<b><u>Clicca qui per resettare il test.</u></b> [<a href=\"admin_nictest_reset.php\">RESET</a>] - [<a href=\"admin_nictest_update_config.php\">Config</a>] - [<a href=\"admin_nictest_restore_config_pwd.php\">Ripristina Password</a>] - [<a href=\"admin_nictest_restore_login1.php\">Login Account 1</a>] - [<a href=\"admin_nictest_restore_login2.php\">Login Account 2</a>]";
 $TEST_STEPS[44]="<b>Nota:</b> RESET ripristina lo stato iniziale, il link restore password è utile se si è fatto il test N.3, i 2 link login sono utili in caso si perda la connessione ad uno dei due account, durante le fasi di test.";

 $TEST_STEPS2[1]="Handshake";
 $TEST_STEPS2[2]="Autenticazione account 1, autenticazione account 2, logout account 2";
 $TEST_STEPS2[3]="Login con modifica della password account 2";
 $TEST_STEPS2[4]="Controllo disponibilità identificatori contatti";
 $TEST_STEPS2[5]="Creazione 3 contatti registrant";
 $TEST_STEPS2[6]="Creazione di 2 contatti tech/admin";
 $TEST_STEPS2[7]="Aggiornamento di un contatto";
 $TEST_STEPS2[8]="Visualizzazione di un contatto";
 $TEST_STEPS2[9]="Verifica disponibilità 2 nomi a dominio";
 $TEST_STEPS2[10]="Creazione di due nomi a dominio";
 $TEST_STEPS2[11]="Aggiunta di vincolo su nome a dominio";
 $TEST_STEPS2[12]="Visualizzazione delle info di un nome a dominio";
 $TEST_STEPS2[13]="Modifica di un nome a dominio";
 $TEST_STEPS2[14]="Modifica Registrante nome a dominio";
 $TEST_STEPS2[15]="Richiesta di modifica Registrar di nome a dominio";
 $TEST_STEPS2[16]="Richiesta di modifica Registrar di nome a dominio con cambio Registrant";

 $TEST_STEPS2[17]="Approvazione della richiesta di modifica Registrar ed pulizia coda di polling";
 $TEST_STEPS2[18]="Modifica dell'authinfo di un nome a dominio";
 $TEST_STEPS2[19]="Richiesta di modifica Registrante contestuale a modifica Registrar";
 $TEST_STEPS2[20]="Approvazione della richiesta di modifica Registrante e Registrar";
 $TEST_STEPS2[21]="Interrogazione della coda di polling";
 $TEST_STEPS2[22]="Cancellazione di un nome a dominio";
 $TEST_STEPS2[23]="Ripristino di un nome a dominio";
 $TEST_STEPS2[24]="Cancellazione di un contatto e verifica della disponibilità di un contactID";
 $TEST_STEPS2[25]="ClientA-REG: verifica della coda di polling, e conservazione ID Messaggio";
 $TEST_STEPS2[26]="ClientA-REG: approvazione trasferimento dominio";
 $TEST_STEPS2[27]="ClientA-REG: cancellazione messaggio dalla coda di polling";
 $TEST_STEPS2[28]="ClientA-REG: verifica della coda di polling, e conservazione ID Messaggio";
 $TEST_STEPS2[29]="ClientA-REG: cancellazione messaggio dalla coda di polling";
 $TEST_STEPS2[30]="Crea Registrant 1";
 $TEST_STEPS2[31]="Crea Registrant 2";
 $TEST_STEPS2[32]="Crea Registrant 3";
 $TEST_STEPS2[33]="Crea Admin 1";
 $TEST_STEPS2[34]="Crea Admin 2";
 $TEST_STEPS2[35]="ClientB-REG: creazione di nuovo contatto registrante HH100";
 $TEST_STEPS2[36]="ClientB-REG: avvio cambio registrar e registrante per dominio test-one.it";
 $TEST_STEPS2[37]="Registrazione Dominio 1";
 $TEST_STEPS2[38]="Registrazione Dominio 2";
 $TEST_STEPS2[39]="Aggiunta di Vincolo";
 $TEST_STEPS2[40]="Info per verifica Vincolo";
 $TEST_STEPS2[41]="Cancellazione di un Contatto";
 $TEST_STEPS2[42]="Verifica di un Contatto";
 $TEST_STEPS2[43]="<b><u>Clicca qui per resettare il test.</u></b> [<a href=\"admin_nictest_reset.php\">RESET</a>] - [<a href=\"admin_nictest_update_config.php\">Config</a>] - [<a href=\"admin_nictest_restore_config_pwd.php\">Ripristina Password</a>] - [<a href=\"admin_nictest_restore_login1.php\">Login Account 1</a>] - [<a href=\"admin_nictest_restore_login2.php\">Login Account 2</a>]";
 $TEST_STEPS2[44]="<b>Nota:</b> RESET ripristina lo stato iniziale, il link restore password è utile se si è fatto il test N.3, i 2 link login sono utili in caso si perda la connessione ad uno dei due account, durante le fasi di test.";

 ##############################################################################
 # Others
 ##############################################################################

 $LANGUAGE[1]="
   <table width=98% cellpadding=8><tr>
    <td width=98%><div align=left>
     <br>
     <b><u>Legenda Operazioni possibili sui Domini</u></b> <br><br>
     <b>[V]</b> = Visualizza informazioni su dominio, gestione vincoli, aggiunta e rimozione. <br><br>
     <b>[R]</b> = Imposta il dominio nello status 12, in modo che vengano riaggiornati tutti i dati. <br><br>
     <b>[Ck]</b> = Verifica se un dominio è libero o registrato, e se il nome è valido. <br><br>
     <b>[Mk]</b> = Prova a creare un dominio sul Server EPP. <br><br>
     <b>[Del]</b> = Per cancellare un dominio dal Server EPP e/o dal Pannello Client EPP. <br><br>
     <b>[Upd]</b> = Permette di modificare i dati di un dominio, se questo non è ancora stato creato sul server. <br><br>
     <b>[UR]</b> = Aggiornamento dominio con cambio Registrante. <br><br>
     <b>[UA]</b> = Aggiornamento dominio con cambio Registrante e Admin. <br><br>
     <b>[Info]</b> = Effettua un check su un dominio sul Server EPP, e restituisce i dati presenti. <br><br>
     <b>[Change]</b> = Relativo alla colonna AuthInfo ne cambia il valore, relativo allo status cambia lo status. <br><br>
     <b>[CkAuth]</b> = Verifica <b>AuthCode</b> dominio, sul Server EPP, e verifica i dati di un dominio presso altro Registrar. <br><br>
     <b>[Restore]</b> = Per ripristinare un dominio cancellato sul Server EPP. <br><br>
     <b>[BackOrder]</b> = Inserisce un dominio nella lista dei domini in prossima cancellazione di cui tentare la registrazione in automatico. <br><br>
     <b>[RemoveOrder]</b> = Rimuove un dominio dalla lista dei domini in prossima cancellazione di cui tentare la registrazione in automatico. <br><br>
     <br>
     <b>[Trf]</b> = Inserisce un dominio per trasferimento sul Server EPP, equivale al link <b>[TrfStart]</b>.. <br><br>
     <b>[TrfStart]</b> = Inizia una procedura di trasferimento per dominio, sul Server EPP, equivale al link <b>[Trf]</b>. <br><br>
     <b>[TrfNewReg]</b> = Inserisce un dominio per trasferimento sul Server EPP, con cambio Registrant. <br><br>
     <b>[TrfDelete]</b> = Cancella di trasferimento di un dominio, sul Server EPP. <br><br>
     <b>[TrfReject]</b> = Rifiuta il trasferimento di un dominio, sul Server EPP. <br><br>
     <b>[TrfApprove]</b> = Approva il trasferimento di un dominio, sul Server EPP. <br><br>
     <b>[MntTrf]</b> = Segna dominio come trasferito, cliccare ad avvenuta conferma del trasferimento nella coda di polling. <br><br>
     <b>[RegTrf]</b> = Segna dominio come trasferito, cliccare ad avvenuta conferma del trasferimento nella coda di polling. <br><br>
     <br>
     <b>[Renew]</b> = Aggiunge un anno alla scadenza del dominio, corrisponde ad effettivo rinnovo per i .IT <br><br>
     <br>
     <b><u>Legenda significati della colonna Status</u></b> <br><br>
     <b>0</b> = Dominio aggiunto al <b>Pannello/Client EPP</b>, è pronto per operazioni. <br><br>
     <b>1</b> = Dominio creato con successo sul <b>Server EPP</b>, è pronto per altre operazioni. <br><br>
     <b>2</b> = Dominio da trasferire sul proprio codice Registrar, da un altro Registrar. <br><br>
     <b>3</b> = Dominio in trasferimento su altro Registrar. <br><br>
     <b>4</b> = Dominio trasferito o registrato presso altro Registrar. <br><br>
     <b>5</b> = Dominio cancellato/disdetto, il dominio può essere ripristinato secondo i termini temporali del Registro.it. <br><br>
     <b>6</b> = Dominio cancellato da meno di 7 giorni, presso altri fornitori. <br><br>
     <b>7</b> = Dominio cancellato da meno di 7 giorni, presso il proprio codice. <br><br>
     <b>8</b> = Nome a dominio riservato, dominio non registrabile. <br><br>
     <b>9</b> = Dominio selezionato per backorder, solo in versione pro. <br><br>
     <b>10</b> = Dominio cancellato da meno di 7 giorni e registrato da altro Registrar. <br><br>
     <b>11</b> = Dominio cancellato da più di 7 giorni. <br><br>
     <b>12</b> = Dominio in fase di migrazione da codice MNT a REG, oppure da REG a REG. <br><br>
     <b>13</b> = Dominio in trasferimento sul proprio codice Registrar, da un Maintainer. <br><br>
     <b>14</b> = Dominio in trasferimento sul proprio codice Registrar, da un Registrar. <br><br>
     <b>15</b> = Dominio in status <b>dnsHold</b>, in questo stato non è possibile alcuna operazione. <br><br>
     <br>
     <b><u>Legenda passaggi di Status e comando Delete</u></b> <br><br>
     <b>Status 1</b> = Delete disdice il dominio e lo mette in Status 5 <br><br>
     <b>Status 0, 4, 6, 7, 8, 10, 11</b> = Delete rimuove il dominio dal pannello 
     <b>Status 2, 5, 9, 12</b> = Delete non è presente come opzione <br><br>
     <b>Delete su Status 5</b> = Da 5 può tornare a 1 tramite comando <b>Restore</b>, Da 5 va inoltre a 7, quando il nic mette nella coda di polling 
     il messaggio di dominio cancellato definitivamente.  <br><br>
     <b>Delete su Status 2</b> = Da 2 può tornare a 0 tramite comando <b>TrfDelete</b> o <b>TrfReject</b> <br><br>
     <b>Delete su Status 9</b> = Da 9 può tornare a 0 tramite opzione <b>Annulla BackOrder</b> <br><br>
    </div></td>
   </tr></table> 
 ";

 $LANGUAGE[2]="
   <table width=98% cellpadding=8><tr>
    <td width=98%><div align=left>
     <br>
     <b><u>Legenda Operazioni possibili sui Contatti</u></b> <br><br>
     <b>[Check]</b> = Verifica se un contatto è libero e valido oppure se è già occupato o non valido. <br><br>
     <b>[Mod]</b> = Per modificare i dati per i contatti, non ancora attivati sul server EPP, i contatti attivati non possono essere modificati, solo cancellati. <br><br>
     <b>[Del]</b> = Per cancellare un contatto dal pannello, oppure dal server EPP, se il contatto è attivo sul server viene cancellato dal server, per cancellarlo dal pannello basta cliccare nuovamente su del, i contatti utilizzati nei domini, non possono essere cancellati. <br><br>
     <b>[Tel]</b> = Per modificare il campo telefono e fax di un contatto attivo sul server. <br><br>
     <b>[Full]</b> = Per modificare i campi di un contatto attivo sul server, che non comportano addebbito in caso di modifica. <br><br>
     <b>[Info]</b> = Effettua un check su un contatto attivo sul server, e restituisce i dati presenti. <br><br>
     <b>[Privacy]</b> = Per modificare l'opzione Privacy per un contatto. <br><br>
     <b>[Crea]</b> = Crea effettivamente un contatto di tipo <b>Registrant</b> sul server EPP, questo tipo di contatti necessitano di Partita Iva o Codice Fiscale. <br><br>
     <b>[Crea Admin]</b> = Crea effettivamente un contatto di tipo <b>Admin/Tech</b> sul server EPP. <br><br>
     <br>
     <b><u>Legenda significati della colonna Status</u></b> <br><br>
     <b>Pending</b> = IL contatto è stato aggiunto in questo <b>Pannello</b> o <b>Client EPP</b>, è quindi possibile provare a creare il contatto sul <b>Server EPP</b>, oppure modificarlo prima di proseguire. <br><br>
     <b>Errors</b> = Si è provato a creare il contatto sul server EPP e si è verificato un qualche errore, è possibile correggere il contatto e riprovare l'operazione. <br><br>
     <b>Active</b> = Indica un contatto di tipo <b>Registrant</b> che è stato creato e quindi è attivo sul <b>Server EPP</b>. <br><br>
     <b>ActiveAdmin</b> = Indica un contatto di tipo <b>Admin/Tech</b> che è stato creato e quindi è attivo sul <b>Server EPP</b>. <br><br>
    </div></td>
   </tr></table> 
 ";

 $LANGUAGE[3]="<b>True</b> per trasferimenti <b>Reg To Reg</b>, <b>False</b> per trasferimenti <b>Mnt To Reg</b>.";
 $LANGUAGE[4]="Sconosciuto";
 $LANGUAGE[5]="Codice EPP del Dominio";
 $LANGUAGE[6]="Cifra da Caricare:";
 $LANGUAGE[7]="Carica Sul Conto";
 $LANGUAGE[8]="Cambia password di accesso, a questo pannello.";
 $LANGUAGE[9]="Nuova Password";
 $LANGUAGE[10]="Aggiorna Password";

 $LANGUAGE[11]="Nome";
 $LANGUAGE[12]="Cognome";
 $LANGUAGE[13]="E-Mail";
 $LANGUAGE[14]="Username";
 $LANGUAGE[15]="Password";
 $LANGUAGE[16]="Registrami Adesso";
 $LANGUAGE[17]="Tipo Utente";
 $LANGUAGE[18]="Stato Account";
 $LANGUAGE[19]="Modifica Adesso";
 $LANGUAGE[20]="Attivo";

 $LANGUAGE[21]="Disattivato";
 $LANGUAGE[22]="Bloccato";
 $LANGUAGE[23]="Admin";
 $LANGUAGE[24]="Gestore";
 $LANGUAGE[25]="Utente";
 $LANGUAGE[26]="Se vuoi veramente procedere alla cancellazione, clicca il bottone sottostante.";
 $LANGUAGE[27]="Clicca per Confermare Cancellazione!";
 $LANGUAGE[28]="Edita";
 $LANGUAGE[29]="Cancella";
 $LANGUAGE[30]="ID";

 $LANGUAGE[31]="NOME";
 $LANGUAGE[32]="COGNOME";
 $LANGUAGE[33]="EMAIL";
 $LANGUAGE[34]="USERNAME";
 $LANGUAGE[35]="PASSWORD";
 $LANGUAGE[36]="TIPO";
 $LANGUAGE[37]="STATO";
 $LANGUAGE[38]="EDITA";
 $LANGUAGE[39]="CANCELLA";
 $LANGUAGE[40]="ID UTENTE:";

 $LANGUAGE[41]="NOME E COGNOME:";
 $LANGUAGE[42]="E-Mail:";
 $LANGUAGE[43]="USERNAME:";
 $LANGUAGE[44]="PASSWORD:";
 $LANGUAGE[45]="TIPO:";
 $LANGUAGE[46]="STATO:";
 $LANGUAGE[47]="Inserisci username e password per effettuare il login.";
 $LANGUAGE[48]="Home Page";
 $LANGUAGE[49]="Log Connessioni EPP";
 $LANGUAGE[50]="Log Operazioni EPP";

 $LANGUAGE[51]="Amministra Dati Default";
 $LANGUAGE[52]="Password Pannello";
 $LANGUAGE[53]="Logout";
 $LANGUAGE[54]="Php server Info";
 $LANGUAGE[55]="Debug Mode Attivo";
 $LANGUAGE[56]="Test cTLD .IT Versione N.1";
 $LANGUAGE[57]="Exam Mode Attivo";
 $LANGUAGE[58]="Next";
 $LANGUAGE[59]="Prev";
 $LANGUAGE[60]="Importa Lista Domini MNT";

 $LANGUAGE[61]="Connessione EPP";
 $LANGUAGE[62]="Crea Contatto";
 $LANGUAGE[63]="Gestione Contatti";
 $LANGUAGE[64]="Crea Dominio";
 $LANGUAGE[65]="Gestione Domini";
 $LANGUAGE[66]="Trasferisci Dominio";
 $LANGUAGE[67]="Polling";
 $LANGUAGE[68]="Gestione Polling";
 $LANGUAGE[69]="HandShake";
 $LANGUAGE[70]="Comandi XML Liberi";

 $LANGUAGE[71]="Link Utili";
 $LANGUAGE[72]="Client:";
 $LANGUAGE[73]="Tipo Utente:";
 $LANGUAGE[74]="Hai effettuato il login come:";
 $LANGUAGE[75]="LOGIN";
 $LANGUAGE[76]="Password:";
 $LANGUAGE[77]="Nome Utente:";
 $LANGUAGE[78]="Hai omesso sia Username che Password.";
 $LANGUAGE[79]="Hai omesso la Username.";
 $LANGUAGE[80]="Hai omesso la Password.";

 $LANGUAGE[81]="Username o Password non valide.";
 $LANGUAGE[82]="Identificazione non valida o sessione scaduta.";
 $LANGUAGE[83]="Accesso ad area riservata per Admin non consentito a questo utente.";
 $LANGUAGE[84]="Accesso ad area riservata per Gestore non consentito a questo utente.";
 $LANGUAGE[85]="Sessione EPP non attiva, o scaduta, operazione non consentita.";
 $LANGUAGE[86]="Per eseguire questa operazione, è necessario prima aprire una connessione EPP.";
 $LANGUAGE[87]="Clicca qui per eseguire una connessione EPP: [<a href=\"admin_index.php\">Connessione EPP</a>]";
 $LANGUAGE[88]="EPP Logout";
 $LANGUAGE[89]="EPP Login";
 $LANGUAGE[90]="Clicca questo bottone per concludere la sessione EPP attuale.";

 $LANGUAGE[91]="Clicca questo bottone per iniziare una sessione EPP.";
 $LANGUAGE[92]="Server EPP:";
 $LANGUAGE[93]="Clicca questo bottone per iniziare una sessione EPP, con cambio password.";
 $LANGUAGE[94]="Server EPP:";
 $LANGUAGE[95]="Nuova Password:";
 $LANGUAGE[96]=" EPP Login e Cambio Password ";
 $LANGUAGE[97]="ID";
 $LANGUAGE[98]="Inizio Sessione EPP";
 $LANGUAGE[99]="Ultima Operazione";
 $LANGUAGE[100]="Status";

 $LANGUAGE[101]="Sessione";
 $LANGUAGE[102]="Credito";
 $LANGUAGE[103]="Code";
 $LANGUAGE[104]="Title";
 $LANGUAGE[105]="Data";
 $LANGUAGE[106]="OP";
 $LANGUAGE[107]="QT";
 $LANGUAGE[108]="XML";
 $LANGUAGE[109]="DEQ";
 $LANGUAGE[110]="DeQueue";

 $LANGUAGE[111]="View";
 $LANGUAGE[112]="DeQueue";
 $LANGUAGE[113]="
  <b><u>Legenda Operazioni possibili</u></b> <br><br>
  <b>[View]</b> = Visualizza il contenuto XML di un messaggio. <br><br>
  <b>[DeQueue]</b> = Elimina un messaggio dalla coda di Polling. <br><br>
 ";
 $LANGUAGE[114]="Nome Dominio";
 $LANGUAGE[115]="Create";
 $LANGUAGE[116]="Update";
 $LANGUAGE[117]="Expire";
 $LANGUAGE[118]="Codice EPP";
 $LANGUAGE[119]="Status";
 $LANGUAGE[120]="Reg / Adm / Tech";

 $LANGUAGE[121]="Del";
 $LANGUAGE[122]="Upd";
 $LANGUAGE[123]="Mk";
 $LANGUAGE[124]="BackOrder";
 $LANGUAGE[125]="V";
 $LANGUAGE[126]="Upd";
 $LANGUAGE[127]="UR";
 $LANGUAGE[128]="UA";
 $LANGUAGE[129]="UT";
 $LANGUAGE[130]="Trf";

 $LANGUAGE[131]="TrfNewReg";
 $LANGUAGE[132]="TrfStart";
 $LANGUAGE[133]="TrfDelete";
 $LANGUAGE[134]="TrfApprove";
 $LANGUAGE[135]="TrfReject";
 $LANGUAGE[136]="Restore";
 $LANGUAGE[137]="RemoveOrder";
 $LANGUAGE[138]="Ck";
 $LANGUAGE[139]="Dns";
 $LANGUAGE[140]="Info";

 $LANGUAGE[141]="CkAuth";
 $LANGUAGE[142]="Change";
 $LANGUAGE[143]="Full";
 $LANGUAGE[144]="RegTrf";
 $LANGUAGE[145]="MntTrf";
 $LANGUAGE[146]="Mk";
 $LANGUAGE[147]="Renew";
 $LANGUAGE[148]="Refresh";
 $LANGUAGE[149]="Check";
 $LANGUAGE[150]="Mod";

 $LANGUAGE[151]="Tentativo fallito di login, omissione di username e password, errore(1).";
 $LANGUAGE[152]="Tentativo fallito di login, omissione di username, errore(2).";
 $LANGUAGE[153]="Tentativo fallito di login, password nulla, errore(3).";
 $LANGUAGE[154]="Login effettuato con successo da utente:";
 $LANGUAGE[155]="Tentativo di accesso non autorizzato, login non valido oppure scaduto.";
 $LANGUAGE[156]="Privacy";
 $LANGUAGE[157]="Tel";
 $LANGUAGE[158]="Crea";
 $LANGUAGE[159]="Crea Admin";
 $LANGUAGE[160]="Tel/Fax.";

 $LANGUAGE[161]="Nz";
 $LANGUAGE[162]="Pr";
 $LANGUAGE[163]="Città";
 $LANGUAGE[164]="CAP";
 $LANGUAGE[165]="Indirizzo";
 $LANGUAGE[166]="Status";
 $LANGUAGE[167]="Nome e Cognome";
 $LANGUAGE[168]="ID / ContactID";
 $LANGUAGE[169]="Aggiorna dati di Default";
 $LANGUAGE[170]="Id Bill";

 $LANGUAGE[171]="Id Tech";
 $LANGUAGE[172]="Id Admin";
 $LANGUAGE[173]="Id Registrante";
 $LANGUAGE[174]="Stato di Esame";
 $LANGUAGE[175]="Stato di Debug";
 $LANGUAGE[176]="Prefisso Contact IDs";
 $LANGUAGE[177]="Indirizzo IP NS(2)";
 $LANGUAGE[178]="Name Server(2)";
 $LANGUAGE[179]="Indirizzo IP NS(1)";
 $LANGUAGE[180]="Name Server(1)";

 $LANGUAGE[181]="Credito Attuale:";
 $LANGUAGE[182]="Trasferimento Dominio";
 $LANGUAGE[183]="Oppure puoi usare un server NS dalla lista dei Name Server che hai creato.";
 $LANGUAGE[184]="Indirizzo IP(2)";
 $LANGUAGE[185]="Indirizzo IP(1)";
 $LANGUAGE[186]="Name Server(2)";
 $LANGUAGE[187]="Name Server(1)";
 $LANGUAGE[188]="Codice EPP";
 $LANGUAGE[189]="Cod. Fatturazione";
 $LANGUAGE[190]="Cod. Tecnico";

 $LANGUAGE[191]="Cod. Amministratore";
 $LANGUAGE[192]="Cod. Registrante";
 $LANGUAGE[193]="Nome Dominio";
 $LANGUAGE[194]="Aggiorna Dominio";
 $LANGUAGE[195]="Crea un Dominio";
 $LANGUAGE[196]="Invia Comando Libero";
 $LANGUAGE[197]="Crea un Contatto";
 $LANGUAGE[198]="Nome";
 $LANGUAGE[199]="Cognome";
 $LANGUAGE[200]="Sesso Utente";

 $LANGUAGE[201]="Ragione Sociale";
 $LANGUAGE[202]="Indirizzo";
 $LANGUAGE[203]="Codice CAP";
 $LANGUAGE[204]="Città";
 $LANGUAGE[205]="Provincia";
 $LANGUAGE[206]="Nazione";
 $LANGUAGE[207]="Nazionalità";
 $LANGUAGE[208]="Tipo Contatto";
 $LANGUAGE[209]="Suffisso ContactID";
 $LANGUAGE[210]="
  (*) <b>Ragione Sociale</b> è un campo necessario per Ditte, Professionisti, Società, Enti, ed Organizzazioni varie. <br><br>
  (**) <b>Codice Fiscale e Partita IVA</b> Sono necessari per i <b>Contatti Registrant</b>, per i <b>privati</b> è necessario il <b>Codice Fiscale</b>, per tutti gli altri la <b>Partita IVA</b>, 
  in alcuni casi di organizzazioni in possesso di solo <b>Codice Fiscale</b>, usare lo stesso, nei casi di soggetti EU senza entrambi, è possibile ometterli entrambi,
  nel caso di <b>Contatti Admin/Tech</b> questi campi non sono necessari. 
 ";

 $LANGUAGE[211]="Codice Fiscale";
 $LANGUAGE[212]="Partita IVA";
 $LANGUAGE[213]="Telefono";
 $LANGUAGE[214]="Fax";
 $LANGUAGE[215]="EMail";
 $LANGUAGE[216]="Privacy";
 $LANGUAGE[217]="Aggiorna Contatto";
 $LANGUAGE[218]="Crea Contatto";
 $LANGUAGE[219]="Aggiorna Telefono Contatto";
 $LANGUAGE[220]="Aggiorna Consenso Privacy";

 $LANGUAGE[221]="True";
 $LANGUAGE[222]="False";
 $LANGUAGE[223]="Errore inaspettato, il campo Dominio non può essere vuoto!";
 $LANGUAGE[224]="Clicca su questo link per tornare a:";
 $LANGUAGE[225]="gestione domini";
 $LANGUAGE[226]="Errore inaspettato, il campo Dominio risulta un duplicato!";
 $LANGUAGE[227]="Pending";
 $LANGUAGE[228]="Active";
 $LANGUAGE[229]="Delete";
 $LANGUAGE[230]="Failed";

 $LANGUAGE[231]="Aggiorna Name Server";
 $LANGUAGE[232]="Oppure puoi usare un server NS dalla lista dei Name Server che hai creato.";
 $LANGUAGE[233]="Indirizzo IPv4(1)";
 $LANGUAGE[234]="Indirizzo IPv4(2)";
 $LANGUAGE[235]="IDL";
 $LANGUAGE[236]="Tipo Evento";
 $LANGUAGE[237]="IP Accesso";
 $LANGUAGE[238]="Data Evento";
 $LANGUAGE[239]="Descrizione Evento";
 $LANGUAGE[240]="IT - Italia";

 $LANGUAGE[241]="IT +39";
 $LANGUAGE[242]="Uomo";
 $LANGUAGE[243]="Donna";
 $LANGUAGE[244]="Seleziona";
 $LANGUAGE[245]="Persona Fisica";
 $LANGUAGE[246]="Registrant";
 $LANGUAGE[247]="Admin";
 $LANGUAGE[248]="Tech";
 $LANGUAGE[249]="Billing";
 $LANGUAGE[250]="Result Code:";

 $LANGUAGE[251]="Reason Code:";
 $LANGUAGE[252]="Server(1)";
 $LANGUAGE[253]="Username(1)";
 $LANGUAGE[254]="Password(1)";
 $LANGUAGE[255]="Server(2)";
 $LANGUAGE[256]="Username(2)";
 $LANGUAGE[257]="Password(2)";
 $LANGUAGE[258]="Aggiorna Configurazione Test";
 $LANGUAGE[259]="ID";
 $LANGUAGE[260]="TLD";

 $LANGUAGE[261]="Descrizione";
 $LANGUAGE[262]="Server";
 $LANGUAGE[263]="Porta";
 $LANGUAGE[264]="Username";
 $LANGUAGE[265]="Password";
 $LANGUAGE[266]="Protocollo";
 $LANGUAGE[267]="Rimuovi";
 $LANGUAGE[268]="Aggiungi Server EPP";
 $LANGUAGE[269]="Indirizzo Server";
 $LANGUAGE[270]="Breve Descrizione";

 $LANGUAGE[271]="Selettore TLD";
 $LANGUAGE[272]="EPP Over TCP";
 $LANGUAGE[273]="EPP Over HTTP";
 $LANGUAGE[274]="EPP Over SMTP";
 $LANGUAGE[275]="EPP Over TCP(v2)";
 $LANGUAGE[276]="EPP Over HTTP(cv)";
 $LANGUAGE[277]="Aggiungi Configurazione Name Server";
 $LANGUAGE[278]="Name Server(3)";
 $LANGUAGE[279]="Indirizzo IP NS(3)";
 $LANGUAGE[280]="Name Server(4)";

 $LANGUAGE[281]="Indirizzo IP NS(4)";
 $LANGUAGE[282]="Name Server(5)";
 $LANGUAGE[283]="Indirizzo IP NS(5)";
 $LANGUAGE[284]="Name Servers";
 $LANGUAGE[285]="Usa EPP in Config";
 $LANGUAGE[286]="Usa Name Server nel Form Sopra";
 $LANGUAGE[287]="
  <b><u>Legenda Vincoli possibili</u></b> <br><br>
  <b>clientUpdateProhibited</b><br><br>
  Vincolo imposto dal Registrar per impedire la modifica di un dominio. Unica operazione consentita, rimozione del suddetto vincolo. 
  Il Registrar non può porre questo vincolo per impedire al Registrante la richiesta di modifica di un dominio, se non in presenza di valide motivazioni.
  <br><br>
  <b>clientTransferProhibited</b><br><br>
  Vincolo imposto dal Registrar per impedire il trasferimento del nome a dominio ad altro Registrar. Il 
  Registrar può porre il veto alla modifica del Registrar soltanto nel caso in cui abbia ricevuto, per tale nome a dominio, 
  un provvedimento dalle autorità competenti, notificato nelle forme di legge.
  <br><br> 
  <b>clientDeleteProhibited</b><br><br>
  Vincolo imposto dal Registrar per impedire la cancellazione del nome a dominio.
  <br><br> 
  <b>clientHold</b><br><br>
  Dominio per il quale il Registrar ha sospeso l'operatività e inibito qualsiasi operazione di modifica, a seguito dell'apertura di un provvedimento giudiziario sul 
  dominio relativo all'uso e/o all'assegnazione dello stesso. Unica operazione consentita: rimozione del <b>\"clientHold\"</b> da parte del Registrar.
 ";
 $LANGUAGE[288]="Aggiungi Vincolo su Dominio";
 $LANGUAGE[289]="Seleziona Vincolo";
 $LANGUAGE[290]="Domain Status";

 $LANGUAGE[291]="Aggiorna password con nuova chiave di decodifica";
 $LANGUAGE[292]="Nuova Chiave";
 $LANGUAGE[293]="Vecchia Chiave";
 $LANGUAGE[294]="
  <b>Tramite questo form è possibile modificare la chiave di decodifica delle password, 
  in particolare la password di login a questo pannello, gli AuthCode dei domini, e le password dei 
  server EPP</b>
  <br><br>
  <b>Importante!!!</b> Se esegui questa procedura, dovrai sostituire la nuova chiave nel file di configurazione 
  generale di questo script manualmente, ricordati di farlo subito dopo questa procedura, non farlo prima altrimenti
  il controllo di correttezza della vecchia chiave fallirà.
 ";
 $LANGUAGE[295]="Aggiorna AuthInfo";
 $LANGUAGE[296]="Nuovo Codice EPP / Auth Info";
 $LANGUAGE[297]="<b>Tramite questo form è possibile modificare l'authinfo del dominio.</b>";
 $LANGUAGE[298]="Importa Lista Domini";
 $LANGUAGE[299]="Lista in formato .TXT";
 $LANGUAGE[300]="
  <b>Tramite questo form è possibile importare la lista dei domini da migrazione MNT.</b>
  <br><br>
  <b>Nota Importante</b>: Per un corretto funzionamento di questa funzione, è necessario impostare i permessi di scrittura
  sulla directory \"import\".
 ";

 $LANGUAGE[301]="Cancellati";
 $LANGUAGE[302]="Attivazioni";
 $LANGUAGE[303]="Trasferimenti";
 $LANGUAGE[304]="In Scadenza";
 $LANGUAGE[305]="Totale Domini:";
 $LANGUAGE[306]="Cerca";
 $LANGUAGE[307]="Totale Profili:";
 $LANGUAGE[308]="Cambia Contatto Tech";
 $LANGUAGE[309]="Inserisci Nuovo Contact Tech";
 $LANGUAGE[310]="Cambia Contatto Admin";

 $LANGUAGE[311]="Inserisci Nuovo Contact Admin";
 $LANGUAGE[312]="Cambia Registrante Dominio";
 $LANGUAGE[313]="Inserisci Nuovo Registrant";
 $LANGUAGE[314]="Unknown";
 $LANGUAGE[315]="Operazione:";
 $LANGUAGE[316]="Programmazione e Strumenti Vari";
 $LANGUAGE[317]="Raccoglitore Patch, Informazioni EPP";
 $LANGUAGE[318]="Sito Giovanni Ceglia";
 $LANGUAGE[319]="Registro Iraniano";
 $LANGUAGE[320]="CentralNic Servizi per EPP";

 $LANGUAGE[321]="Registrar HexoNet.com";
 $LANGUAGE[322]="Forum TrovaHosting.eu";
 $LANGUAGE[323]="Forum AlVerde.net";
 $LANGUAGE[324]="Forum Domainers.it";
 $LANGUAGE[325]="Forum HostingTalk.it";
 $LANGUAGE[326]="Aggiornamenti ed altri Tools";
 $LANGUAGE[327]="Registri e Registrar con EPP";
 $LANGUAGE[328]="Forum e Gruppi di discussione";
 $LANGUAGE[329]="Siti e Portali Registro.it";
 $LANGUAGE[330]="Portale REGISTRO.IT - registro.it";

 $LANGUAGE[331]="Portale NIC.IT - nic.it";
 $LANGUAGE[332]="Portale ARP - arp.nic.it";
 $LANGUAGE[333]="Portale RAIN-NG - rain-ng.nic.it";
 $LANGUAGE[334]="Portale RAIN - rain.nic.it";
 $LANGUAGE[335]="Connessione chiusa dal server remoto.";
 $LANGUAGE[336]="Errore in lettura:";
 $LANGUAGE[337]="Dimensione lunghezza di testa, errata dal server.";
 $LANGUAGE[338]="Errore generico.";
 $LANGUAGE[339]="Errore in chiamata a Curl:";
 $LANGUAGE[340]="Si è verificato un errore nella connessione al database.";

 $LANGUAGE[341]="Errore MySQL:";
 $LANGUAGE[342]="Tentativo di modifica chiave di decodifica password fallito.";
 $LANGUAGE[343]="Sessione di login terminata.";
 $LANGUAGE[344]="Tentativo di modifica chiave di decodifica password fallito.";
 $LANGUAGE[345]="Contact ROID:";
 $LANGUAGE[346]="Registrar ClID:";
 $LANGUAGE[347]="Registrar CrID:";
 $LANGUAGE[348]="Domain Status:";
 $LANGUAGE[349]="ID Registrante:";
 $LANGUAGE[350]="ID Admin:";

 $LANGUAGE[351]="Data Creazione:";
 $LANGUAGE[352]="Data Aggiornamento:";
 $LANGUAGE[353]="Data Scadenza:";
 $LANGUAGE[354]="Name Server NS1:";
 $LANGUAGE[355]="Name Server NS2:";
 $LANGUAGE[356]="Auth Info:";
 $LANGUAGE[357]="Nome e Cognome:";
 $LANGUAGE[358]="Organizzazione:";
 $LANGUAGE[359]="Indirizzo:";
 $LANGUAGE[360]="Città:";

 $LANGUAGE[361]="Provincia:";
 $LANGUAGE[362]="Codice CAP:";
 $LANGUAGE[363]="Nazione:";
 $LANGUAGE[364]="Telefono:";
 $LANGUAGE[365]="Num. Fax:";
 $LANGUAGE[366]="E-Mail:";
 $LANGUAGE[367]="Nazionalità:";
 $LANGUAGE[368]="Tipo Utente:";
 $LANGUAGE[369]="Cod. Fiscale:";
 $LANGUAGE[370]="Privacy:";

 $LANGUAGE[371]="Data Creazione:";
 $LANGUAGE[372]="Data Aggiornamento:";
 $LANGUAGE[373]="Contact Status:";
 $LANGUAGE[374]="Pagina Generica EPP Client";
 $LANGUAGE[375]="Pagina di Login - EPP Client";
 $LANGUAGE[376]="Naked XML - EPP Command.";
 $LANGUAGE[377]="Pagina Test di Accreditamento Nic.IT - EPP Client";
 $LANGUAGE[378]="Nuovo Username";
 $LANGUAGE[379]="Controllo codice Contact ID:";
 $LANGUAGE[380]="Comando EPP eseguito con successo!";

 $LANGUAGE[381]="IL codice";
 $LANGUAGE[382]="risulta libero e disponibile.";
 $LANGUAGE[383]="non risulta libero.";
 $LANGUAGE[384]="Result Code:";
 $LANGUAGE[385]="Reason Code:";
 $LANGUAGE[386]="Sessione HTTPS attuale:";
 $LANGUAGE[387]="Errore operazione EPP:";
 $LANGUAGE[388]="[Microtime]";
 $LANGUAGE[389]="Microseconds for Hello:";
 $LANGUAGE[390]="HandShake - EPP Hello.";

 $LANGUAGE[391]="Messaggio rilevato:";
 $LANGUAGE[392]="quantità:";
 $LANGUAGE[393]="data:";
 $LANGUAGE[394]="message:";
 $LANGUAGE[395]="Controllo coda di polling.";
 $LANGUAGE[396]="Comando di polling eseguito con successo, nessun messaggio in coda!";
 $LANGUAGE[397]="Comando di polling eseguito con successo, uno o più messaggi sono in coda!";
 $LANGUAGE[398]="Info contatto con codice Contact ID:";
 $LANGUAGE[399]="Connessione TCP:";
 $LANGUAGE[400]="Configurazione Selezionata:";

 $LANGUAGE[401]="Protocollo Configurazione:";
 $LANGUAGE[402]="Scambio messaggi di Handshake";
 $LANGUAGE[403]="Login EPP Eseguito, Credito:";
 $LANGUAGE[404]="Sessione EPP:";
 $LANGUAGE[405]="Sessione in chiusura:";
 $LANGUAGE[406]="Nuova password impostata:";
 $LANGUAGE[407]="<b>Ricordati</b> di impostare la nuova password nel file di configurazione in /conf/config.inc.php.";
 $LANGUAGE[408]="Vai alla pagina di login:";
 $LANGUAGE[409]="Pagina di Login EPP";
 $LANGUAGE[410]="Operazione di importazione terminata.";

 $LANGUAGE[411]="domini importati";
 $LANGUAGE[412]="Torna alla lista dei domini.";
 $LANGUAGE[413]="Disconnessione/logout, effettuato con successo.";
 $LANGUAGE[414]="Tentativo di modifica chiave di decodifica riuscito.";
 $LANGUAGE[415]="OLDKEY:";
 $LANGUAGE[416]="Torna al pannello.";
 $LANGUAGE[417]="Dati aggiornati, torna clicca qui per tornare all'indice dei <a href=\"admin_nictest.php\">TEST</a>.";
 $LANGUAGE[418]="<b>Logout</b>";
 $LANGUAGE[419]="Sessione HTTPS:";
 $LANGUAGE[420]="Hello, su server:";

 $LANGUAGE[421]="Risposta al comando Hello:";
 $LANGUAGE[422]="Login";
 $LANGUAGE[423]="Logout";
 $LANGUAGE[424]="Salvataggio del messaggio ID:";
 $LANGUAGE[425]="per successive operazioni!";
 $LANGUAGE[426]="Controllo dominio:";
 $LANGUAGE[427]="Cambio AuthCode Dominio fallito:";
 $LANGUAGE[428]="AuthCode Dominio cambiato con successo:";
 $LANGUAGE[429]="Verifica disponibilità dominio fallita:";
 $LANGUAGE[430]="Verifica disponibilità dominio riuscita:";

 $LANGUAGE[431]="Errore nella cancellazione del dominio:";
 $LANGUAGE[432]="Disponibilità Dominio:";
 $LANGUAGE[433]="IL dominio";
 $LANGUAGE[434]="è disponibile per registrazione.";
 $LANGUAGE[435]="non è disponibile.";
 $LANGUAGE[436]="IL dominio non è disponibile perchè:";
 $LANGUAGE[437]="Dominio creato con successo:";
 $LANGUAGE[438]="Creazione dominio fallita:";
 $LANGUAGE[439]="Cancellazione Dominio:";
 $LANGUAGE[440]="Comando fallito, siccome il dominio già non esiste! Lo stato del dominio è stato mutato. ";

 $LANGUAGE[441]="Dominio non cancellato perchè inesistente:";
 $LANGUAGE[442]="Dominio cancellato con successo:";
 $LANGUAGE[443]="Verifica fallita per AuthInfo del dominio:";
 $LANGUAGE[444]="Codice epp per questo dominio:";
 $LANGUAGE[445]="Effettuata verifica AuthInfo per dominio:";
 $LANGUAGE[446]="Controllo Lista Domini:";
 $LANGUAGE[447]="Verifica disponibilità domini fallita.";
 $LANGUAGE[448]="Verifica disponibilità domini riuscita.";
 $LANGUAGE[449]="Dominio:";
 $LANGUAGE[450]="Disponibilità:";

 $LANGUAGE[451]="Contatto <b>Admin</b> creato con successo:";
 $LANGUAGE[452]="Contatto Admin creato con successo:";
 $LANGUAGE[453]="Errore creazione Contatto Admin:";
 $LANGUAGE[454]="IL contatto è stato eliminato dal server EPP con successo!";
 $LANGUAGE[455]="L'oggetto non esite sul server EPP.";
 $LANGUAGE[456]="Ripristino Dominio:";
 $LANGUAGE[457]="Errore nel ripristino del dominio:";
 $LANGUAGE[458]="Dominio ripristinato con successo:";
 $LANGUAGE[459]="Contatto Tech Dominio aggiornato con successo:";
 $LANGUAGE[460]="Contatto Tech Dominio fallito:";

 $LANGUAGE[461]="Operazione Libera XML:";
 $LANGUAGE[462]="IL dominio";
 $LANGUAGE[463]="risulta libero e disponibile.";
 $LANGUAGE[464]="non risulta libero.";
 $LANGUAGE[465]="Controllo dominio:";
 $LANGUAGE[466]="Cancellazione Messaggio dalla Coda di Polling:";
 $LANGUAGE[467]="Errore nella cancellazione di messaggio da coda polling:";
 $LANGUAGE[468]="Messaggio eliminato dalla coda di polling con successo:";
 $LANGUAGE[469]="Errore creazione Contatto Registrant:";
 $LANGUAGE[470]="Contatto <b>Registrant</b> creato con successo:";

 $LANGUAGE[471]="Avvio con successo di richiesta di trasferimento dominio, con cambio Registrant:";
 $LANGUAGE[472]="Cambio Registrar e Registrar Dominio fallito:";
 $LANGUAGE[473]="Avvio con successo di richiesta di trasferimento dominio:";
 $LANGUAGE[474]="Cambio Registrar Dominio fallito:";
 $LANGUAGE[475]="Approvazione trasferimento dominio avvenuta con successo:";
 $LANGUAGE[476]="Approvazione trasferimento dominio fallita:";
 $LANGUAGE[477]="Cancellazione trasferimento dominio avvenuta con successo:";
 $LANGUAGE[478]="Cancellazione trasferimento dominio fallita:";
 $LANGUAGE[479]="Completamento trasferimento dominio da codice MNT, avvenuto con successo:";
 $LANGUAGE[480]="Errore durante completamento trasfermento da MNT:";

 $LANGUAGE[481]="Completamento trasferimento dominio da codice REG, avvenuto con successo:";
 $LANGUAGE[482]="Errore durante completamento trasfermento da REG:";
 $LANGUAGE[483]="Rifiuto trasferimento dominio avvenuto con successo:";
 $LANGUAGE[484]="Rifiuto trasferimento dominio fallito:";
 $LANGUAGE[485]="Avvio con successo di richiesta di trasferimento dominio:";
 $LANGUAGE[486]="Cambio Registrar Dominio fallito:";
 $LANGUAGE[487]="Aggiornamento dati contatto eseguito con successo:";
 $LANGUAGE[488]="Errore aggiornamento dati contatto per Contatto:";
 $LANGUAGE[489]="Aggiornamento privacy eseguito con successo su:";
 $LANGUAGE[490]="Errore aggiornamento Privacy per Contatto:";

 $LANGUAGE[491]="Aggiornamento Telefono eseguito con successo:";
 $LANGUAGE[492]="Errore aggiornamento Telefono in Contatto:";
 $LANGUAGE[493]="Aggiunta stato/vincolo riuscita con successo:";
 $LANGUAGE[494]="Aggiunta stato/vincolo fallita:";
 $LANGUAGE[495]="Contatto Admin Dominio aggiornato con successo:";
 $LANGUAGE[496]="Contatto Admin Dominio fallito:";
 $LANGUAGE[497]="Admin e Registrant Dominio aggiornati con successo:";
 $LANGUAGE[498]="Cambio Admin e Registrant Dominio fallito:";
 $LANGUAGE[499]="Rimozione stato/vincolo avvenuta con successo su:";
 $LANGUAGE[500]="Rimozione stato/vincolo fallita:";

 $LANGUAGE[501]="Aggiornamento Name Server Dominio:";
 $LANGUAGE[502]="Aggiornamento Name Server Dominio riuscito con successo:";
 $LANGUAGE[503]="Aggiornamento Name Server Dominio richiesto con successo, azione pendente:";
 $LANGUAGE[504]="Aggiornamento Name Server Dominio fallito:";
 $LANGUAGE[505]="Registrant Dominio aggiornato con successo:";
 $LANGUAGE[506]="Cambio Registrant Dominio fallito:";
 $LANGUAGE[507]="Login EPP in corso...";
 $LANGUAGE[508]="Errore durante Login EPP!";
 $LANGUAGE[509]="- Login eseguito con successo.";
 $LANGUAGE[510]="Polling EPP Server in corso...";

 $LANGUAGE[511]="- Polling eseguito con successo. ";
 $LANGUAGE[512]="DeQueue Messaggio dalla coda di Polling in corso...";
 $LANGUAGE[513]="- Errore nel prelevamento messaggio dalla coda di polling.";
 $LANGUAGE[514]="Errore nella cancellazione di messaggio da coda polling:";
 $LANGUAGE[515]="- Messaggio prelevato con successo.";
 $LANGUAGE[516]="- Messaggio eliminato con successo.";
 $LANGUAGE[517]="Messaggio eliminato dalla coda di polling con successo:";
 $LANGUAGE[518]="Logout EPP in corso...";
 $LANGUAGE[519]="[Chiamata API]";
 $LANGUAGE[520]="Contatto Registrant creato con successo:";

 $LANGUAGE[521]="Forum Programmatore.eu";
 $LANGUAGE[522]="Forum Consulente.eu";
 $LANGUAGE[523]="Forum AspMonkey.com";
 $LANGUAGE[524]="Forum CPlusPlus.eu";
 $LANGUAGE[525]="Forum PhpItaly.it";
 $LANGUAGE[526]="Forum Html.it";
 $LANGUAGE[527]="Forum WebHostingForum.it";
 $LANGUAGE[528]="Forum WebHostingTalk.com";
 $LANGUAGE[529]="Forum DnForum.com";
 $LANGUAGE[530]="Forum SitePoint.com";

 $LANGUAGE[531]="Forum DigitalPoint.com";
 $LANGUAGE[532]="LOGIN";
 $LANGUAGE[533]="LOGOUT";
 $LANGUAGE[534]="Torna al Client EPP";
 $LANGUAGE[535]="Name Server(3)";
 $LANGUAGE[536]="Indirizzo IPv4(3)";
 $LANGUAGE[537]="Name Server(4)";
 $LANGUAGE[538]="Indirizzo IPv4(4)";
 $LANGUAGE[539]="Name Server(5)";
 $LANGUAGE[540]="Indirizzo IPv4(5)";

 $LANGUAGE[541]="Name Server NS3:";
 $LANGUAGE[542]="Name Server NS4:";
 $LANGUAGE[543]="Name Server NS5:";
 $LANGUAGE[544]="Cambia utente e password di accesso, a questo pannello.";
 $LANGUAGE[545]="Domain";
 $LANGUAGE[546]="Vecchi NS:";
 $LANGUAGE[547]="Ultimo Post EPP";
 $LANGUAGE[548]="Ultimo Post EPP ed Http Header";
 $LANGUAGE[549]="Test cTLD .IT Versione N.2";
 $LANGUAGE[550]="
  Problema grave nel caricamento comando/schema XML, probabilmente non è stato specificato un percorso corretto 
  nella configurazione.
 ";

 $LANGUAGE[551]="Dominio non cancellabile perchè registrato presso altri";
 $LANGUAGE[552]="Sincronizza Tutto";
 $LANGUAGE[553]="Crea Dominio";
 $LANGUAGE[554]="Sessione di Login EPP Scaduta.";
 $LANGUAGE[555]="Errore non previsto, nessuna operazione eseguita.";
 $LANGUAGE[556]="R";
 $LANGUAGE[557]="Change";
 $LANGUAGE[558]="Aggiorna Status";
 $LANGUAGE[559]="Codice Status";
 $LANGUAGE[560]="Operazione non consentita";

 $LANGUAGE[561]="
  Seleziona <b>NO</b> se desideri aggiungere i Name Server indicati senza cancellare quelli assegnati in precedenza. 
  Questa opzione è utile per risolvere alcune situazioni di errore, come Name Server errati nel caso di <b>dnsHold</b>.
 ";
 $LANGUAGE[562]="Si";
 $LANGUAGE[563]="No";
 $LANGUAGE[564]="Indirizzo IPv4(6)";
 $LANGUAGE[565]="Indirizzo IPv6(1)";
 $LANGUAGE[566]="Indirizzo IPv6(2)";
 $LANGUAGE[567]="Indirizzo IPv6(3)";
 $LANGUAGE[568]="Indirizzo IPv6(4)";
 $LANGUAGE[569]="Indirizzo IPv6(5)";
 $LANGUAGE[570]="Indirizzo IPv6(6)";

 $LANGUAGE[571]="Name Server(6)";
 $LANGUAGE[572]="Contatti Admin/Tech";
 $LANGUAGE[573]="Child DNS";
 $LANGUAGE[574]="Questo dominio non è nello status attivo nel pannello EPP, tuttavia è presente nel pannello normale:";
 $LANGUAGE[575]="[EPP-Normal-Panel] Warning Mistake Detected:";
 $LANGUAGE[576]="Questo dominio è in scadenza e non è presente nel pannello normale:";
 $LANGUAGE[577]="[EPP-Normal-Panel] Warning Not Found:";
 $LANGUAGE[578]="Rinnovo dominio:";
 $LANGUAGE[579]="[EPP-Normal-Panel] Domain Renew:";

 $LANGUAGE[580]="...";
 $LANGUAGE[581]="Controllo:";
 $LANGUAGE[582]="Indirizzo IP Sorgente:";
 $LANGUAGE[583]="Connessione avvenuta con successo!";
 $LANGUAGE[584]="Bulk NS Update";
 $LANGUAGE[585]="Bulk Transfer";
 $LANGUAGE[586]="Approva Tutti i Trasferimenti";
 $LANGUAGE[587]="Bulk Trade &amp; Transfer";
 $LANGUAGE[588]="Forzare l\'aggiornamento dei Name Server a trasferimento avvenuto?";
 $LANGUAGE[589]="Registra in Bulk";

 $LANGUAGE[590]="Bulk Modifica Contatti";
 $LANGUAGE[591]="Reseller e Crediti";
 $LANGUAGE[592]="Pannello EPP";
 $LANGUAGE[593]="Azzera Lista Domini";
 $LANGUAGE[594]="Pulizia Lista Domini";
 $LANGUAGE[595]="Questa operazione rimuoverà tutti i domini che sono in status 0 (Non Definito), 4-8, 10-11.";
 $LANGUAGE[596]="Questa operazione rimuoverà tutti i domini dal pannello.";
 $LANGUAGE[597]="Conferma";
 $LANGUAGE[598]="AutoRenew Ultimo Giorno";
 $LANGUAGE[599]="Archivia Polling";

 $LANGUAGE[600]="Bulk Cancella";
 $LANGUAGE[601]="Cancella un gruppo di domini, inserire domini uno per riga.";
 $LANGUAGE[602]="Per effettuare una operazione registrazione bulk, inserire i domini 1 per riga.";
 $LANGUAGE[603]="Registra domini";
 $LANGUAGE[604]="Aggiorna contatti";
 $LANGUAGE[605]="I contatti lasciati in bianco, non verranno modificati. In caso il contatto Registrant, sia di tipo Privato, va inserito lo stesso anche nell'Admin";
 $LANGUAGE[606]="Per effettuare una operazione modifica contatti bulk, inserire i domini 1 per riga.";
 $LANGUAGE[607]="Per cancellare un gruppo di domini, inserire i domini uno per riga.";
 $LANGUAGE[608]="Cancella domini";
 $LANGUAGE[609]="Dominio cancellato con successo:";

 $LANGUAGE[610]="Operazione di cancellazione sul dominio, fallita!";
 $LANGUAGE[611]="Bulk Restore";
 $LANGUAGE[612]="Dominio ripristinato con successo:";
 $LANGUAGE[613]="Operazione di ripristino sul dominio, fallita!";
 $LANGUAGE[614]="<b> Per prelevare una lista di domini con codice epp, senza interrogare il server del Nic, inserire i domini, uno per riga. </b>";
 $LANGUAGE[615]="Preleva codici EPP";
 $LANGUAGE[616]="<b> Per approvare il trasferimento di una lista di domini, inserire i domini, uno per riga. </b>";
 $LANGUAGE[617]="Approva trasferimenti.";
 $LANGUAGE[618]="<b> Per effettuare una operazione trasferimento bulk da altro Registrar, inserire i domini 1 per riga, nella forma \"dominio authinfo\", ovvero <b>dominio spazio authinfo</b>.";
 $LANGUAGE[619]="Per effettuare una operazione bulk con cambio Registrant e trasferimento da altro Registrar, inserire i domini 1 per riga, nella forma \"dominio authinfo\", ovvero <b>dominio spazio authinfo</b>, ed inserire il codice Registrant nell'apposito campo.";

 $LANGUAGE[620]="Per ripristinare un gruppo di domini, inserire un dominio per riga.";
 $LANGUAGE[621]="Ripristina";
 $LANGUAGE[622]="Avvio con successo del cambio contatto sul dominio:";
 $LANGUAGE[623]="Cambio contatto fallito"; $LANGUAGE[624]="";
 $LANGUAGE[624]="";
 $LANGUAGE[625]="Cancella il dominio ad inizio scadenza";
 $LANGUAGE[626]="Gestione coda cancellazioni";
 $LANGUAGE[627]="Cancella il dominio sul Registro";
 $LANGUAGE[628]="Rimuovi il dominio dal pannello";
 $LANGUAGE[629]="Cancella il dominio alla fine del grace period";

 $LANGUAGE[630]="Dominio in coda di cancellazione ad inizio scadenza, autorenew";
 $LANGUAGE[631]="Dominio in coda di cancellazione alla fine di scadenza, autorenew";
 $LANGUAGE[632]="Cancellazioni ad inizio scadenza o autorenew";
 $LANGUAGE[633]="Cancellazioni a fine scadenza o autorenew";
 $LANGUAGE[634]="Cancellazioni in coda";
 $LANGUAGE[635]="Autorenew";
 $LANGUAGE[636]="";
 $LANGUAGE[637]="";
 $LANGUAGE[638]="";
 $LANGUAGE[639]="";

 $LANGUAGE[640]="";

?>