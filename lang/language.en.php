<?
 #ini_set('display_errors', 1); 
 #ini_set('display_startup_errors', 1); 
 #error_reporting(E_ALL);

 global $EPPERR,$EPPREA,$EPPGEN,$TEST_STEPS,$LANGUAGE,$LANG_DIR;
 header('Content-Type: text/html; charset=iso-8859-1');

 ##############################################################################
 # Generic Error Meaning
 ##############################################################################

 $LANG_DIR="en";

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
 $TEST_STEPS[2]="Login";
 $TEST_STEPS[3]="Password Update";
 $TEST_STEPS[4]="Polling Queue Checking";
 $TEST_STEPS[5]="Checking Contact IDs";
 $TEST_STEPS[6]="Create 3 Registrant Contacts";
 $TEST_STEPS[7]="Create 2 tech/admin Contacts";
 $TEST_STEPS[8]="Contact Updating";
 $TEST_STEPS[9]="Visualize one Contact";
 $TEST_STEPS[10]="Verification for availability of 2 domain names";
 $TEST_STEPS[11]="Creation of 2 domain names";
 $TEST_STEPS[12]="Visualization and info about a domain name";
 $TEST_STEPS[13]="Modification of a domain name";
 $TEST_STEPS[14]="Modification of Registrant for a domain name";
 $TEST_STEPS[15]="Second Account Authentication";
 $TEST_STEPS[16]="Request to modify the Registrar for a Domain Name";
 $TEST_STEPS[17]="Accept request to modify the Registrar and clean the polling queue";
 $TEST_STEPS[18]="Authinfo update for a domain name";
 $TEST_STEPS[19]="Request to modify Registrant and Registrar at the same time";
 $TEST_STEPS[20]="Accept request to modify Registrant and Registrar";
 $TEST_STEPS[21]="Add and remove a constrain on a domain name and show info";
 $TEST_STEPS[22]="Delete a domain name";
 $TEST_STEPS[23]="Restore a domain name";
 $TEST_STEPS[24]="Delete a contact and check the availability of a contactID";
 $TEST_STEPS[25]="ClientA-REG: check the polling queue,  and store the ID of the message";
 $TEST_STEPS[26]="ClientA-REG: approve the transfer of the domain";
 $TEST_STEPS[27]="ClientA-REG: delete the message from the polling queue";
 $TEST_STEPS[28]="ClientA-REG: check the polling queue and store the ID of the message";
 $TEST_STEPS[29]="ClientA-REG: delete the message from the polling queue";
 $TEST_STEPS[30]="Create Registrant 1";
 $TEST_STEPS[31]="Create Registrant 2";
 $TEST_STEPS[32]="Create Registrant 3";
 $TEST_STEPS[33]="Create Admin 1";
 $TEST_STEPS[34]="Create Admin 2";
 $TEST_STEPS[35]="ClientB-REG: create a Registrant Contact HH100";
 $TEST_STEPS[36]="ClientB-REG: start the change of Registrar and Registrant for the domain test-one.it";
 $TEST_STEPS[37]="Domain Registration 1";
 $TEST_STEPS[38]="Domain Registration 2";
 $TEST_STEPS[39]="Adding a constrain";
 $TEST_STEPS[40]="Removing a constrain";
 $TEST_STEPS[41]="Contact Deleting";
 $TEST_STEPS[42]="Contact Verification";

 ##############################################################################
 # Others
 ##############################################################################

 $LANGUAGE[1]="
   <table width=98% cellpadding=8><tr>
    <td width=98%><div align=left>
     <br>
     <b><u>Explaination about the operations available on Domain Names</u></b> <br><br>
     <b>[V]</b> = Show information about a domain, costrains admin, adding and removing. <br><br>
     <b>[Ck]</b> = To verify if a domain is free or registered, and if the domain is a valid name. <br><br>
     <b>[Mk]</b> = Try to create a domain on the EPP Server. <br><br>
     <b>[Del]</b> = To delete a domain from the EPP Server or from this EPP Panel. <br><br>
     <b>[Upd]</b> = To update info about a domain, se questo non è ancora stato creato sul server. <br><br>
     <b>[UR]</b> = Update a domain and update the Registrant. <br><br>
     <b>[UA]</b> = Update a domain and update the Registrant and Admin. <br><br>
     <b>[Info]</b> = Check a domain on EPP Server, and show the info. <br><br>
     <b>[CkAuth]</b> = To verify a domain <b>AuthCode</b>, on EPP Server, and check data for a domain on another Registrar. <br><br>
     <b>[Restore]</b> = To restore a deleted domain on EPP Server. <br><br>
     <b>[BackOrder]</b> = Add the domain name into the list of domains to try to capture at the deletion. <br><br>
     <b>[RemoveOrder]</b> = Remove a domain from the list of domain next to deletion, queued to try a new registration. <br><br>
     <br>
     <b>[Trf]</b> = Add a domain for transfer, on the EPP Server. <br><br>
     <b>[TrfNewReg]</b> = Add a domain for transfer, on the EPP Server, with Registrant update. <br><br>
     <b>[TrfStart]</b> = Start the procedure of stransfer for a domain, on EPP Server. <br><br>
     <b>[TrfDelete]</b> = Delete a transfer for a domain, on EPP Server. <br><br>
     <b>[TrfReject]</b> = Refuse the transfer for a domain name, on EPP Server. <br><br>
     <b>[TrfApprove]</b> = Approve the transfer of a domain, on the EPP Server. <br> <br>
     <b>[MntTrf]</b> = Mark domain as transferred, click after successful transfer in the polling queue. <br> <br>
     <b>[RegTrf]</b> = Mark domain as transferred, click after successful transfer in the polling queue. <br> <br>
     <br>
     <b>[Renew]</b> = Adds a year to the expiration of the domain, it corresponds to the actual renewal for .IT <br> <br>
     <br>
     <b><u>Key to the meaning of the Status column </u></b><br><br>
     <b>0</b> = Domain added to <b> Panel / EPP Client </b>, ready for operation. <br> <br>
     <b>1</b> = Domain successfully created on the <b> EPP Server </b>, it is ready for other operations. <br> <br>
     <b>2</b> = Domain being transferred to your Registrar code by another Registrar. <br> <br>
     <b>3</b> = Domain being transferred to another Registrar. <br> <br>
     <b>4</b> = Domain transferred or registered with another Registrar. <br> <br>
     <b>5</b> = Domain canceled / canceled, the domain can be restored according to the terms of the Registry.it. <br> <br>
     <b>6</b> = Domain canceled less than 7 days ago by other providers. <br> <br>
     <b>7</b> = Domain canceled less than 7 days ago, at your code. <br> <br>
     <b>8</b> = Reserved domain name, domain cannot be registered. <br> <br>
     <b>9</b> = Domain selected for backorder, only in pro version. <br> <br>
     <b>10</b> = Domain canceled less than 7 days ago and registered by another Registrar. <br> <br>
     <b>11</b> = Domain deleted more than 7 days ago. <br> <br>
     <b>12</b> = Domain being migrated from MNT to REG code. <br> <br>
     <b>13</b> = Domain being transferred to your Registrar code by a Maintainer. <br> <br>
     <b>14</b> = Domain being transferred to your Registrar code by a Registrar. <br> <br>
     <br>
     <b><u>Instructions for Status steps and Delete command </u> </b> <br><br>
     <b>Status 1</b> = Delete cancels the domain and puts it in Status 5 <br> <br>
     <b>Status 0, 4, 6, 7, 8, 10, 11</b> = Delete removes the domain from the panel
     <b>Status 2, 5, 9, 12</b> = Delete is not present as an option <br> <br>
     <b>Delete on Status 5</b> = From 5 can go back to 1 via <b> Restore </b> command, From 5 also goes to 7, when the nic puts in the polling queue the domain message permanently deleted. <br> <br>
     <b>Delete on Status 2</b> = From 2 can go back to 0 by <b> TrfDelete </b> or <b> TrfReject </b> <br> <br>
     <b>Delete on Status 9</b> = From 9 you can go back to 0 by <b> Cancel BackOrder </b> <br> <br>
    </div></td>
   </tr></table> 
 ";

 $LANGUAGE[2]="
   <table width=98% cellpadding=8><tr>
    <td width=98%><div align=left>
     <br>
     <b> <u> Instruction for Possible Operations on Contacts </u> </b> <br> <br>
     <b> [Check] </b> = Check if a contact is free and valid or if it is already busy or invalid. <br> <br>
     <b> [Mod] </b> = To modify the data for the contacts, not yet activated on the EPP server, the activated contacts cannot be modified, only deleted. <br> <br>
     <b> [Del] </b> = To delete a contact from the panel, or from the EPP server, if the contact is active on the server it is deleted from the server, to delete it from the panel just click again on del, the contacts used in the domains , cannot be deleted. <br> <br>
     <b> [Tel] </b> = To change the telephone and fax field of an active contact on the server. <br> <br>
     <b> [Full] </b> = To modify the fields of an active contact on the server, which do not incur a charge in case of modification. <br> <br>
     <b> [Info] </b> = Checks an active contact on the server, and returns the data present. <br> <br>
     <b> [Privacy] </b> = To change the Privacy option for a contact. <br> <br>
     <b> [Create] </b> = It actually creates a <b> Registrant </b> contact on the EPP server, this type of contacts require a VAT number or Tax Code. <br> <br>
     <b> [Create Admin] </b> = Actually create a contact of type <b> Admin / Tech </b> on the EPP server. <br> <br>
     <br>
     <b> <u> Key to the meaning of the Status column </u> </b> <br> <br>
     <b> Pending </b> = The contact has been added in this <b> Panel </b> or <b> EPP Client </b>, you can then try to create the contact on the <b> EPP Server < / b>, or modify it before continuing. <br> <br>
     <b> Errors </b> = You tried to create the contact on the EPP server and some error occurred, you can correct the contact and retry the operation. <br> <br>
     <b> Active </b> = Indicates a <b> Registrant </b> contact that has been created and is therefore active on the <b> EPP Server </b>. <br> <br>
     <b> ActiveAdmin </b> = Indicates a contact of type <b> Admin / Tech </b> that has been created and is therefore active on the <b> EPP Server </b>. <br> <br>
    </div></td>
   </tr></table> 
 ";

 $LANGUAGE[3]="<b>True</b> for transfers <b>Reg To Reg</b>, <b>False</b> for transfers <b>Mnt To Reg</b>.";
 $LANGUAGE[4]="Unknown";
 $LANGUAGE[5]="EPP Code for Domain";

 $LANGUAGE[6]="Amount to Upload:";
 $LANGUAGE[7]="Upload on Account";
 $LANGUAGE[8]="This module will change access password, for this panel.";
 $LANGUAGE[9]="New Password";
 $LANGUAGE[10]="Update Password";

 $LANGUAGE[11]="Name";
 $LANGUAGE[12]="Last name";
 $LANGUAGE[13]="EMail";
 $LANGUAGE[14]="Username";
 $LANGUAGE[15]="Password";
 $LANGUAGE[16]="Register now";
 $LANGUAGE[17]="User Type";
 $LANGUAGE[18]="Account Status";
 $LANGUAGE[19]="Update Now";
 $LANGUAGE[20]="Active";

 $LANGUAGE[21]="Inactive";
 $LANGUAGE[22]="Blocked";
 $LANGUAGE[23]="Admin";
 $LANGUAGE[24]="Administrator";
 $LANGUAGE[25]="User";
 $LANGUAGE[26]="If you want to proceed with deletetion, click the button.";
 $LANGUAGE[27]="Click to confirm deletion!";
 $LANGUAGE[28]="Edit";
 $LANGUAGE[29]="Delete";
 $LANGUAGE[30]="ID";

 $LANGUAGE[31]="NAME";
 $LANGUAGE[32]="LAST NAME";
 $LANGUAGE[33]="EMAIL";
 $LANGUAGE[34]="USERNAME";
 $LANGUAGE[35]="PASSWORD";
 $LANGUAGE[36]="TYPE";
 $LANGUAGE[37]="STATUS";
 $LANGUAGE[38]="EDIT";
 $LANGUAGE[39]="DELETE";
 $LANGUAGE[40]="USER ID:";

 $LANGUAGE[41]="NAME AND LAST NAME:";
 $LANGUAGE[42]="EMail:";
 $LANGUAGE[43]="USERNAME:";
 $LANGUAGE[44]="PASSWORD:";
 $LANGUAGE[45]="TYPE:";
 $LANGUAGE[46]="STATE:";
 $LANGUAGE[47]="Insert username and password to login.";
 $LANGUAGE[48]="Home Page";
 $LANGUAGE[49]="Log EPP Accesses";
 $LANGUAGE[50]="Log EPP Operations";

 $LANGUAGE[51]="Admin Default Info";
 $LANGUAGE[52]="EPP Panel Password";
 $LANGUAGE[53]="Logout";
 $LANGUAGE[54]="Php server Info";
 $LANGUAGE[55]="Debug Mode Active";
 $LANGUAGE[56]="Test Registro.it";
 $LANGUAGE[57]="Exam Mode Active";
 $LANGUAGE[58]="Next";
 $LANGUAGE[59]="Prev";
 $LANGUAGE[60]="Import Domain List or MNT List";

 $LANGUAGE[61]="EPP Connection";
 $LANGUAGE[62]="Create Contact";
 $LANGUAGE[63]="Admin Contacts";
 $LANGUAGE[64]="Create Domain";
 $LANGUAGE[65]="Admin Domains";
 $LANGUAGE[66]="Transfer Domain";
 $LANGUAGE[67]="Polling";
 $LANGUAGE[68]="Admin Polling Queue";
 $LANGUAGE[69]="HandShake";
 $LANGUAGE[70]="Free XML Commands";

 $LANGUAGE[71]="Useful Links";
 $LANGUAGE[72]="Client:";
 $LANGUAGE[73]="User Type:";
 $LANGUAGE[74]="You logged as:";
 $LANGUAGE[75]="LOGIN";
 $LANGUAGE[76]="Password:";
 $LANGUAGE[77]="Username:";
 $LANGUAGE[78]="You missed both Username and Password.";
 $LANGUAGE[79]="You missed the Username.";
 $LANGUAGE[80]="You missed the Password.";

 $LANGUAGE[81]="Bad Username or Password.";
 $LANGUAGE[82]="Login not valid, or expired session.";
 $LANGUAGE[83]="Access to reserved area, not allowed for this user.";
 $LANGUAGE[84]="Access to reserved area for Admin, not allowed to this user.";
 $LANGUAGE[85]="EPP Session not active, or expired, operation not allowed.";
 $LANGUAGE[86]="To execute this operation, you need to open an EPP Connection.";
 $LANGUAGE[87]="Click here to start an EPP Session: [<a href=\"admin_index.php\">EPP Connection</a>]";
 $LANGUAGE[88]="EPP Logout";
 $LANGUAGE[89]="EPP Login";
 $LANGUAGE[90]="Click here to stop this EPP Session.";

 $LANGUAGE[91]="Click here to start an EPP Session.";
 $LANGUAGE[92]="Server EPP:";
 $LANGUAGE[93]="Click here to start an EPP Session, cahnging password.";
 $LANGUAGE[94]="Server EPP:";
 $LANGUAGE[95]="New Password:";
 $LANGUAGE[96]=" EPP Login and Password Update";
 $LANGUAGE[97]="ID";
 $LANGUAGE[98]="EPP Sessiont Start";
 $LANGUAGE[99]="Last Operation";
 $LANGUAGE[100]="Status";

 $LANGUAGE[101]="Session";
 $LANGUAGE[102]="Credit";
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
  <b><u>Information and documentation about possible operations</u></b> <br><br>
  <b>[View]</b> = To View XML Content of a Message. <br><br>
  <b>[DeQueue]</b> = Remove a message from the Polling Queue. <br><br>
 ";
 $LANGUAGE[114]="Domain Name";
 $LANGUAGE[115]="Create";
 $LANGUAGE[116]="Update";
 $LANGUAGE[117]="Expire";
 $LANGUAGE[118]="EPP Code";
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

 $LANGUAGE[151]="Failed Login Attempt, missing username and password, error(1).";
 $LANGUAGE[152]="Failed Login Attempt, missing username, error(2).";
 $LANGUAGE[153]="Failed Login Attempt, missing password, error(3).";
 $LANGUAGE[154]="Login successfully for user:";
 $LANGUAGE[155]="Login Attempt not authorized, login not valid or expired.";
 $LANGUAGE[156]="Privacy";
 $LANGUAGE[157]="Tel";
 $LANGUAGE[158]="Create";
 $LANGUAGE[159]="Create Admin";
 $LANGUAGE[160]="Tel/Fax.";

 $LANGUAGE[161]="Nz";
 $LANGUAGE[162]="Pr";
 $LANGUAGE[163]="City";
 $LANGUAGE[164]="ZipCode";
 $LANGUAGE[165]="Address";
 $LANGUAGE[166]="Status";
 $LANGUAGE[167]="First and Last Name";
 $LANGUAGE[168]="ID / ContactID";
 $LANGUAGE[169]="Update Default Info";
 $LANGUAGE[170]="Id Bill";

 $LANGUAGE[171]="Id Tech";
 $LANGUAGE[172]="Id Admin";
 $LANGUAGE[173]="Id Registrante";
 $LANGUAGE[174]="Exam State";
 $LANGUAGE[175]="Debug State";
 $LANGUAGE[176]="Prefisso Contact IDs";
 $LANGUAGE[177]="IPv4 Address(2)";
 $LANGUAGE[178]="Name Server(2)";
 $LANGUAGE[179]="IPv4 Address(1)";
 $LANGUAGE[180]="Name Server(1)";

 $LANGUAGE[181]="Current Credit:";
 $LANGUAGE[182]="Domain Transfer";
 $LANGUAGE[183]="Or you can use an NS server from the Name Server list you created.";
 $LANGUAGE[184]="IP Address(2)";
 $LANGUAGE[185]="IP Address(1)";
 $LANGUAGE[186]="Name Server(2)";
 $LANGUAGE[187]="Name Server(1)";
 $LANGUAGE[188]="Codice EPP";
 $LANGUAGE[189]="Cod. Billing";
 $LANGUAGE[190]="Cod. Tech";

 $LANGUAGE[191]="Cod. Admin";
 $LANGUAGE[192]="Cod. Registrant";
 $LANGUAGE[193]="Domain Name";
 $LANGUAGE[194]="Domain Update";
 $LANGUAGE[195]="Create a Domain";
 $LANGUAGE[196]="Send a free XML Command";
 $LANGUAGE[197]="Create a Contact";
 $LANGUAGE[198]="First Name";
 $LANGUAGE[199]="Last Name";
 $LANGUAGE[200]="User Sex";

 $LANGUAGE[201]="Company or Entity Name";
 $LANGUAGE[202]="Address";
 $LANGUAGE[203]="Zip Code";
 $LANGUAGE[204]="City";
 $LANGUAGE[205]="State or Province";
 $LANGUAGE[206]="Country";
 $LANGUAGE[207]="Nationality";
 $LANGUAGE[208]="Contact Type";
 $LANGUAGE[209]="ContactID suffix";
 $LANGUAGE[210]="
  (*) <b>Company Name or Entity Name</b> it is a necessary field for companies, professionals, companies, organizations, and various organizations. <br> <br>
  (**) <b> Tax Code and VAT Number </b> They are required for <b> Registrant Contacts </b>, for <b> private individuals </b> <b> Tax Code </ b>, for all others the <b> VAT number </b>,
  in some cases of organizations in possession of only <b> Tax Code </b>, use the same, in cases of EU subjects without both, it is possible to omit both,
  in the case of <b> Admin / Tech Contacts </b> these fields are not required.
 ";

 $LANGUAGE[211]="Private Fiscal Code";
 $LANGUAGE[212]="VAT Code";
 $LANGUAGE[213]="Tel";
 $LANGUAGE[214]="Fax";
 $LANGUAGE[215]="EMail";
 $LANGUAGE[216]="Privacy";
 $LANGUAGE[217]="Contact Update";
 $LANGUAGE[218]="Contact Create";
 $LANGUAGE[219]="Update Contact Phone";
 $LANGUAGE[220]="Update Privacy Consent";

 $LANGUAGE[221]="True";
 $LANGUAGE[222]="False";
 $LANGUAGE[223]="Unexpected error, the Domain field cannot be empty!";
 $LANGUAGE[224]="Click on this link to return to:";
 $LANGUAGE[225]="domain management";
 $LANGUAGE[226]="Unexpected error, the Domain field is a duplicate!";
 $LANGUAGE[227]="Pending";
 $LANGUAGE[228]="Active";
 $LANGUAGE[229]="Delete";
 $LANGUAGE[230]="Failed";

 $LANGUAGE[231]="Update Name Server";
 $LANGUAGE[232]="Or you can use an NS server from the list of Name Servers you have created.";
 $LANGUAGE[233]="IP address (1)";
 $LANGUAGE[234]="IP address (2)";
 $LANGUAGE[235]="IDL";
 $LANGUAGE[236]="Event Type";
 $LANGUAGE[237]="Access IP";
 $LANGUAGE[238]="Event Date";
 $LANGUAGE[239]="Event Description";
 $LANGUAGE[240]="IT - Italy";


 $LANGUAGE[241]="IT +39";
 $LANGUAGE[242]="Man";
 $LANGUAGE[243]="Woman";
 $LANGUAGE[244]="Select";
 $LANGUAGE[245]="Individual";
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
 $LANGUAGE[258]="Update Test Configuration";
 $LANGUAGE[259]="ID";
 $LANGUAGE[260]="TLD";

 $LANGUAGE[261]="Description";
 $LANGUAGE[262]="Server";
 $LANGUAGE[263]="Port";
 $LANGUAGE[264]="Username";
 $LANGUAGE[265]="Password";
 $LANGUAGE[266]="Protocol";
 $LANGUAGE[267]="Remove";
 $LANGUAGE[268]="Add EPP Server";
 $LANGUAGE[269]="Server Address";
 $LANGUAGE[270]="Short Description";

 $LANGUAGE[271]="TLD Selector (Example: IT)";
 $LANGUAGE[272]="EPP Over TCP";
 $LANGUAGE[273]="EPP Over HTTP";
 $LANGUAGE[274]="EPP Over SMTP";
 $LANGUAGE[275]="EPP Over TCP(v2)";
 $LANGUAGE[276]="EPP Over HTTP(cv)";
 $LANGUAGE[277]="Add a Name Server Configuration";
 $LANGUAGE[278]="Name Server(3)";
 $LANGUAGE[279]="IP Address NS(3)";
 $LANGUAGE[280]="Name Server(4)";

 $LANGUAGE[281]="IP Address NS(4)";
 $LANGUAGE[282]="Name Server(5)";
 $LANGUAGE[283]="IP Address NS(5)";
 $LANGUAGE[284]="Name Servers";
 $LANGUAGE[285]="Use EPP in Config";
 $LANGUAGE[286]="Use Name Server on Above Form";
 $LANGUAGE[287]="
  <b> <u> Documentation about Possible constraints </u> </b> <br> <br>
  <b> clientUpdateProhibited </b> <br> <br>
  constrain imposed by the Registrar to prevent the modification of a domain. The only operation allowed, removal of the aforementioned constrain.
  The Registrar cannot set this constrain to prevent the Registrant from requesting a domain change, except in the presence of valid reasons.
  <br> <br>
  <b> clientTransferProhibited </b> <br> <br>
  constrain imposed by the Registrar to prevent the transfer of the domain name to another Registrar. The
  Registrar may veto the change of Registrar only if it has received, for this domain name,
  a provision by the competent authorities, notified in the forms of law.
  <br> <br>
  <b> clientDeleteProhibited </b> <br> <br>
  constrain imposed by the Registrar to prevent the cancellation of the domain name.
  <br> <br>
  <b> clientHold </b> <br> <br>
  Domain for which the Registrar has suspended operations and inhibited any modification, following the opening of a court order on
  domain relating to the use and / or assignment of the same. The only operation allowed: removal of the <b> \"clientHold\" </b> by the Registrar.
 ";
 $LANGUAGE[288]="Add a constrain on Domain";
 $LANGUAGE[289]="Select a constrain";
 $LANGUAGE[290]="Domain Status";

 $LANGUAGE[291]="Update password with a new Decrypting Key";
 $LANGUAGE[292]="New Crypting Key";
 $LANGUAGE[293]="Old Crypting Key";
 $LANGUAGE[294]="
  <b> Through this form you can change the password decryption key,
  in particular the login password to this panel, the AuthCodes of the domains, and the passwords of the
  EPP server </b>
  <br> <br>
  <b> Important !!! </b> If you perform this procedure, you will need to replace the new key in the configuration file
  general of this script manually, remember to do it right after this procedure, don't do it before otherwise
  the correctness check of the old key will fail.
 ";
 $LANGUAGE[295]="Update AuthInfo";
 $LANGUAGE[296]="New EPP Code / Auth Info";
 $LANGUAGE[297]="<b> Through this form it is possible to modify the authhinfo of the domain. </b>";
 $LANGUAGE[298]="Import Domain List";
 $LANGUAGE[299]="List in .TXT format";

 $LANGUAGE[300]="
  <b> Through this form it is possible to import the list of domains from MNT migration. </b>
  <br> <br>
  <b> Important Note </b>: For this function to work properly, you need to set write permissions
  to the \"import\" directory.
 ";

 $LANGUAGE[301]="Canceled";
 $LANGUAGE[302]="Activations";
 $LANGUAGE[303]="Transfers";
 $LANGUAGE[304]="Expiring";
 $LANGUAGE[305]="Total Domains:";
 $LANGUAGE[306]="Search";
 $LANGUAGE[307]="Total Profiles:";
 $LANGUAGE[308]="Change Tech Contact";
 $LANGUAGE[309]="Insert New Contact Tech";
 $LANGUAGE[310]="Change Admin Contact";

 $LANGUAGE[311]="Enter New Contact Admin";
 $LANGUAGE[312]="Change Domain Registrant";
 $LANGUAGE[313]="Enter New Registrant";
 $LANGUAGE[314]="Unknown";
 $LANGUAGE[315]="Operation:";
 $LANGUAGE[316]="Programming and Various Tools";
 $LANGUAGE[317]="Patch Collector, EPP Information";
 $LANGUAGE[318]="Giovanni Ceglia Website";
 $LANGUAGE[319]="Iranian Registry";
 $LANGUAGE[320]="CentralNic Services for EPP";

 $LANGUAGE[321]="Registrar HexoNet.com";
 $LANGUAGE[322]="Forum TrovaHosting.eu";
 $LANGUAGE[323]="Forum AlVerde.net";
 $LANGUAGE[324]="Forum Domainers.it";
 $LANGUAGE[325]="Forum HostingTalk.it";
 $LANGUAGE[326]="Updates and other Tools";
 $LANGUAGE[327]="Registers and Registrars with EPP";
 $LANGUAGE[328]="Forums and Discussion Groups";
 $LANGUAGE[329]="Registro.it sites and portals";
 $LANGUAGE[330]="REGISTRO.IT Portal - registro.it";
 $LANGUAGE[331]="NIC.IT Portal- nic.it";
 $LANGUAGE[332]="ARP Portal - arp.nic.it";
 $LANGUAGE[333]="RAIN-NG Portal - rain-ng.nic.it";
 $LANGUAGE[334]="RAIN Portal - rain.nic.it";
 $LANGUAGE[335]="Connection closed by remote server.";
 $LANGUAGE[336]="Error on reading:";
 $LANGUAGE[337]="Head length size, incorrect from server.";
 $LANGUAGE[338]="Generic Error.";
 $LANGUAGE[339]="Error calling Curl:";
 $LANGUAGE[340]="There was an error connecting to the database.";

 $LANGUAGE[341]="MySQL Error:";
 $LANGUAGE[342]="Attempt to change password decryption key failed.";
 $LANGUAGE[343]="Login Session Expired.";
 $LANGUAGE[344]="Attempt to change password decryption key failed.";
 $LANGUAGE[345]="Contact ROID:";
 $LANGUAGE[346]="Registrar ClID:";
 $LANGUAGE[347]="Registrar CrID:";
 $LANGUAGE[348]="Domain Status:";
 $LANGUAGE[349]="Registrant ID:";
 $LANGUAGE[350]="Admin ID:";

 $LANGUAGE[351]="Creation Date:";
 $LANGUAGE[352]="Update Date:";
 $LANGUAGE[353]="Expiring Date:";
 $LANGUAGE[354]="Name Server NS1:";
 $LANGUAGE[355]="Name Server NS2:";
 $LANGUAGE[356]="Auth Info:";
 $LANGUAGE[357]="First Name and Last Name:";
 $LANGUAGE[358]="Company Name or Entity:";
 $LANGUAGE[359]="Address:";
 $LANGUAGE[360]="City:";

 $LANGUAGE[361]="Province:";
 $LANGUAGE[362]="ZIP code:";
 $LANGUAGE[363]="Country:";
 $LANGUAGE[364]="Phone:";
 $LANGUAGE[365]="Fax number:";
 $LANGUAGE[366]="EMail:";
 $LANGUAGE[367]="Nationality:";
 $LANGUAGE[368]="User Type:";
 $LANGUAGE[369]="Tax Code:";
 $LANGUAGE[370]="Privacy:";

 $LANGUAGE[371]="Creation date:";
 $LANGUAGE[372]="Update Date:";
 $LANGUAGE[373]="Contact Status:";
 $LANGUAGE[374]="Generic EPP Client Page";
 $LANGUAGE[375]="Login Page - EPP Client";
 $LANGUAGE[376]="Naked XML - EPP Command.";
 $LANGUAGE[377]="Nic.IT - EPP Client Accreditation Test Page";
 $LANGUAGE[378]="New Username";
 $LANGUAGE[379]="Contact ID code check:";
 $LANGUAGE[380]="EPP command executed successfully!";

 $LANGUAGE[381]="THE code";
 $LANGUAGE[382]="is free and available.";
 $LANGUAGE[383]="is not free.";
 $LANGUAGE[384]="Result Code:";
 $LANGUAGE[385]="Reason Code:";
 $LANGUAGE[386]="Current HTTPS session:";
 $LANGUAGE[387]="EPP operation error:";
 $LANGUAGE[388]="[Microtime]";
 $LANGUAGE[389]="Microseconds for Hello:";
 $LANGUAGE[390]="HandShake - EPP Hello.";

 $LANGUAGE[391]="Message:";
 $LANGUAGE[392]="amount:";
 $LANGUAGE[393]="date:";
 $LANGUAGE[394]="message:";
 $LANGUAGE[395]="Controlling polling Queue.";
 $LANGUAGE[396]="Polling Command executed successfully, no messages in queue!";
 $LANGUAGE[397]="Polling command successful, one or more messages are queued!";
 $LANGUAGE[398]="Contact info with Contact ID code:";
 $LANGUAGE[399]="TCP connection:";
 $LANGUAGE[400]="Selected Configuration:";

 $LANGUAGE[401]="Configuration Protocol:";
 $LANGUAGE[402]="Handshake message exchange";
 $LANGUAGE[403]="EPP Login Success, Credit:";
 $LANGUAGE[404]="EPP session:";
 $LANGUAGE[405]="Session ending:";
 $LANGUAGE[406]="New password set:";
 $LANGUAGE[407]="<b> Remember </b> to set the new password in the configuration file in /conf/config.inc.php.";
 $LANGUAGE[408]="Go to login page:";
 $LANGUAGE[409]="EPP Login Page";
 $LANGUAGE[410]="Import operation completed.";

 $LANGUAGE[411]="imported domains";
 $LANGUAGE[412]="Return to the domain list.";
 $LANGUAGE[413]="Logout / logout, successful.";
 $LANGUAGE[414]="The attempt to change the decryption key was successful.";
 $LANGUAGE[415]="OLDKEY:";
 $LANGUAGE[416]="Return to the panel.";
 $LANGUAGE[417]="Updated data, come back click here to return to the index of <a href=\"admin_nictest.php\"> TEST </a>.";
 $LANGUAGE[418]="<b> Logout </b>";
 $LANGUAGE[419]="HTTPS session:";
 $LANGUAGE[420]="Hello, on server:";

 $LANGUAGE[421]="Response to the Hello command:";
 $LANGUAGE[422]="Login";
 $LANGUAGE[423]="Logout";
 $LANGUAGE[424]="Saving the ID message:";
 $LANGUAGE[425]="for subsequent operations!";
 $LANGUAGE[426]="Domain control:";
 $LANGUAGE[427]="Domain AuthCode change failed:";
 $LANGUAGE[428]="AuthCode Domain changed successfully:";
 $LANGUAGE[429]="Failed to check domain availability:";
 $LANGUAGE[430]="Successful domain availability check:";

 $LANGUAGE[431]="Error deleting the domain:";
 $LANGUAGE[432]="Domain Availability:";
 $LANGUAGE[433]="THE domain";
 $LANGUAGE[434]="is available for registration.";
 $LANGUAGE[435]="is not available.";
 $LANGUAGE[436]="The domain is not available because:";
 $LANGUAGE[437]="Domain created successfully:";
 $LANGUAGE[438]="Domain creation failed:";
 $LANGUAGE[439]="Delete Domain:";
 $LANGUAGE[440]="Command failed, as the domain does not already exist! The status of the domain has changed.";

 $LANGUAGE[441]="Domain not deleted because it does not exist:";
 $LANGUAGE[442]="Domain successfully deleted:";
 $LANGUAGE[443]="Failed to verify domain AuthInfo:";
 $LANGUAGE[444]="Epp code for this domain:";
 $LANGUAGE[445]="AuthInfo verification for domain:";
 $LANGUAGE[446]="Domain List Control:";
 $LANGUAGE[447]="Failed to check domains availability.";
 $LANGUAGE[448]="Successful check of domain availability.";
 $LANGUAGE[449]="Domain:";
 $LANGUAGE[450]="Availability:";

 $LANGUAGE[451]="<b>Admin</b> contact created successfully:";
 $LANGUAGE[452]="Admin contact created successfully:";
 $LANGUAGE[453]="Error creating Admin Contact:";
 $LANGUAGE[454]="The contact was successfully deleted from the EPP server!";
 $LANGUAGE[455]="The object does not exist on the EPP server.";
 $LANGUAGE[456]="Domain recovery:";
 $LANGUAGE[457]="Error restoring domain:";
 $LANGUAGE[458]="Domain successfully restored:";
 $LANGUAGE[459]="Tech Contact Domain updated successfully:";
 $LANGUAGE[460]="Domain Tech Contact failed:";

$LANGUAGE[461]="Free XML Operation:";
 $LANGUAGE[462]="The domain";
 $LANGUAGE[463]="is free and available.";
 $LANGUAGE[464]="is not free.";
 $LANGUAGE[465]="Domain control:";
 $LANGUAGE[466]="Deleting Message from Polling Queue:";
 $LANGUAGE[467]="Error deleting message from polling queue:";
 $LANGUAGE[468]="Message deleted from polling queue successfully:";
 $LANGUAGE[469]="Error creating Registrant Contact:";
 $LANGUAGE[470]="<b>Registrant</b> contact created successfully:";

 $LANGUAGE[471]="Successful start of domain transfer request, with change of Registrant:";
 $LANGUAGE[472]="Change of Registrar and Domain Registrar failed:";
 $LANGUAGE[473]="Successful start of domain transfer request:";
 $LANGUAGE[474]="Domain Registrar Change Failed:";
 $LANGUAGE[475]="Domain transfer approval was successful:";
 $LANGUAGE[476]="Domain transfer approval failed:";
 $LANGUAGE[477]="Domain transfer canceled successfully:";
 $LANGUAGE[478]="Cancellation of domain transfer failed:";
 $LANGUAGE[479]="Completion of domain transfer from MNT code, successful:";
 $LANGUAGE[480]="Error while completing transfer from MNT:";

 $LANGUAGE[481]="Successful completion of domain transfer from REG code:";
 $LANGUAGE[482]="Error while completing transfer from REG:";
 $LANGUAGE[483]="Domain transfer refused successful:";
 $LANGUAGE[484]="Failed to transfer domain:";
 $LANGUAGE[485]="Successful start of domain transfer request:";
 $LANGUAGE[486]="Failed to change domain registrar:";
 $LANGUAGE[487]="Contact data updated successfully:";
 $LANGUAGE[488]="Error updating contact data for Contact:";
 $LANGUAGE[489]="Privacy update successful on:";
 $LANGUAGE[490]="Error updating Privacy for Contact:";

 $LANGUAGE[491]="Phone update successful:";
 $LANGUAGE[492]="Error updating Contact Phone:";
 $LANGUAGE[493]="Add status / constrain successful:";
 $LANGUAGE[494]="Failed to add status / constrain:";
 $LANGUAGE[495]="Contact Admin Domain updated successfully:";
 $LANGUAGE[496]="Domain Admin contact failed:";
 $LANGUAGE[497]="Admin and Domain Registrant updated successfully:";
 $LANGUAGE[498]="Change Admin and Domain Registrant failed:";
 $LANGUAGE[499]="Status / constrain removal successful on:";
 $LANGUAGE[500]="Status / constrain removal failed:";

 $LANGUAGE[501]="Domain Name Server Update:";
 $LANGUAGE[502]="Domain Name Server update succeeded:";
 $LANGUAGE[503]="Domain Name Server update requested successfully, action pending:";
 $LANGUAGE[504]="Domain Name Server update failed:";
 $LANGUAGE[505]="Domain Registrant updated successfully:";
 $LANGUAGE[506]="Domain Registrant Change Failed:";
 $LANGUAGE[507]="EPP login in progress ...";
 $LANGUAGE[508]="Error logging into EPP!";
 $LANGUAGE[509]="- Login successful.";
 $LANGUAGE[510]="EPP Server polling ...";

 $LANGUAGE[511]="- Polling successful.";
 $LANGUAGE[512]="DeQueue Message from the Polling queue ...";
 $LANGUAGE[513]="- Error getting message from polling queue.";
 $LANGUAGE[514]="Error deleting message from polling queue:";
 $LANGUAGE[515]="- Message successfully retrieved.";
 $LANGUAGE[516]="- $CODE message successfully deleted.";
 $LANGUAGE[517]="The message was successfully removed by polling queue:";
 $LANGUAGE[518]="Executing EPP Logout...";
 $LANGUAGE[519]="[API Call]";
 $LANGUAGE[520]="Registrant Contact was successfully created:";

 $LANGUAGE[521]="Forum Programmatori.net";
 $LANGUAGE[522]="---";
 $LANGUAGE[523]="---";
 $LANGUAGE[524]="---";
 $LANGUAGE[525]="---";
 $LANGUAGE[526]="Forum Html.it";
 $LANGUAGE[527]="Forum WebHostingForum.it";
 $LANGUAGE[528]="Forum WebHostingTalk.com";
 $LANGUAGE[529]="Forum DnForum.com";
 $LANGUAGE[530]="Forum SitePoint.com";

 $LANGUAGE[531]="Forum DigitalPoint.com";
 $LANGUAGE[532]="LOGIN";
 $LANGUAGE[533]="LOGOUT";
 $LANGUAGE[534]="Back to EPP Client";
 $LANGUAGE[535]="Name Server(3)";
 $LANGUAGE[536]="IPv4 Address(3)";
 $LANGUAGE[537]="Name Server(4)";
 $LANGUAGE[538]="IPv4 Address(4)";
 $LANGUAGE[539]="Name Server(5)";
 $LANGUAGE[540]="IPv4 Address(5)";

 $LANGUAGE[541]="Name Server NS3:";
 $LANGUAGE[542]="Name Server NS4:";
 $LANGUAGE[543]="Name Server NS5:";
 $LANGUAGE[544]="Update username and password for this panel/interface.";
 $LANGUAGE[545]="Domain";
 $LANGUAGE[546]="Old NS:";
 $LANGUAGE[547]="Last EPP Post";
 $LANGUAGE[548]="Last EPP Post And Http Header";
 $LANGUAGE[549]="Test cTLD .IT Version N.2";
 $LANGUAGE[550]="
  Problem loading XML command or scheme, you should specify the correct path in configuration file, or configuration setup.
 ";

 $LANGUAGE[551]="Domain can't be deleted because it is registered with another Registrar";
 $LANGUAGE[552]="Syncronize All";
 $LANGUAGE[553]="Create Domain";
 $LANGUAGE[554]="Expired Login Session.";
 $LANGUAGE[555]="Unexpected Error, no operation was executed.";
 $LANGUAGE[556]="R";
 $LANGUAGE[557]="Change";
 $LANGUAGE[558]="Update Status";
 $LANGUAGE[559]="Status Code";
 $LANGUAGE[560]="Not Authorizated Operation";

 $LANGUAGE[561]="
  Select <b>NO</b> if you desire to add Name Servers without removing old ones. This option is usefull to resolve
  some error states, as bad Name Servers when <b>dnsHold</b> state.
 ";
 $LANGUAGE[562]="Yes";
 $LANGUAGE[563]="No";
 $LANGUAGE[564]="IPv4 Address(6)";
 $LANGUAGE[565]="IPv6 Address(1)";
 $LANGUAGE[566]="IPv6 Address(2)";
 $LANGUAGE[567]="IPv6 Address(3)";
 $LANGUAGE[568]="IPv6 Address(4)";
 $LANGUAGE[569]="IPv6 Address(5)";
 $LANGUAGE[570]="IPv6 Address(6)";

 $LANGUAGE[571]="Name Server(6)";
 $LANGUAGE[572]="Admin/Tech Contacts";
 $LANGUAGE[573]="Child DNS";
 $LANGUAGE[574]="This domain isn't into active status in EPP Panel, but it is into the normal panel:";
 $LANGUAGE[575]="[EPP-Normal-Panel] Warning Mistake Detected:";
 $LANGUAGE[576]="This domain is expiring and it isn't into normal panel:";
 $LANGUAGE[577]="[EPP-Normal-Panel] Warning Not Found:";
 $LANGUAGE[578]="Renew domain:";
 $LANGUAGE[579]="[EPP-Normal-Panel] Domain Renew:";

 $LANGUAGE[580]="...";
 $LANGUAGE[581]="Controlling:";
 $LANGUAGE[582]="Source IP Address:";
 $LANGUAGE[583]="Successfully Connected!";
 $LANGUAGE[584]="Bulk NS Update";
 $LANGUAGE[585]="Bulk Transfer";
 $LANGUAGE[586]="Approve All Transfers";
 $LANGUAGE[587]="Bulk Trade &amp; Transfer";
 $LANGUAGE[588]="Do you want to force Name Server, after transfer?";
 $LANGUAGE[589]="Bulk Register";

 $LANGUAGE[590]="Bulk Contact Update";
 $LANGUAGE[591]="Reseller and Credits";
 $LANGUAGE[592]="EPP Panel";
 $LANGUAGE[593]="Clear Domain List";
 $LANGUAGE[594]="Clean up Domain List";
 $LANGUAGE[595]="This operation will remove all domains that are in status 0 (Not Defined), 4-8, 10-11.";
 $LANGUAGE[596]="This will remove all domains from the panel.";
 $LANGUAGE[597]="Confirm";
 $LANGUAGE[598]="AutoRenew Last Day";
 $LANGUAGE[599]="Archive Polling";

 $LANGUAGE[600]="Bulk Delete";
 $LANGUAGE[601]="Delete a group of domains, enter domains one per line.";
 $LANGUAGE[602]="To perform a bulk registration operation, enter 1 domains per line.";
 $LANGUAGE[603]="Register domains";
 $LANGUAGE[604]="Update contacts";
 $LANGUAGE[605]="The contacts left blank will not be modified. If the Registrant contact, is a Private type, it must also be entered in the Admin";
 $LANGUAGE[606]="To perform a bulk contact change operation, enter the domains 1 per line.";
 $LANGUAGE[607]="To delete a group of domains, add domains one for row.";
 $LANGUAGE[608]="Delete domains";
 $LANGUAGE[609]="Domain successfully deleted:";

 $LANGUAGE[610]="Operation of Delete Domain, failed!";
 $LANGUAGE[611]="Bulk Restore";
 $LANGUAGE[612]="Domain restored successfully:";
 $LANGUAGE[613]="Operation of Domain Restore, failed!";
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
 $LANGUAGE[625]="Delete the domain on expire starting";
 $LANGUAGE[626]="Admin deleting queue";
 $LANGUAGE[627]="Delete the domain on the Registry";
 $LANGUAGE[628]="Remove the domain by the panel";
 $LANGUAGE[629]="Delete the domain at the end of grace period";

 $LANGUAGE[630]="Domain in queue for deleting on expire, autorenew starting";
 $LANGUAGE[631]="Domain in queue for deleting on expire, autorenew ending";
 $LANGUAGE[632]="Deleting on expire autorenew starting";
 $LANGUAGE[633]="Deleting on expire autorenew ending";
 $LANGUAGE[634]="";
 $LANGUAGE[635]="";
 $LANGUAGE[636]="";
 $LANGUAGE[637]="";
 $LANGUAGE[638]="";
 $LANGUAGE[639]="";

 $LANGUAGE[640]="";

?>