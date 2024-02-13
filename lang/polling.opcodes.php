<?
 global $POLLCOD, $NPOLLCOD;

 $NPOLLCOD=31;

 $POLLCOD[1]="dnsHold is started";
 $POLLCOD[2]="DNS check ended successfully";
 $POLLCOD[3]="DNS check ended unsuccessfully";
 $POLLCOD[4]="autoRenewPeriod is started";
 $POLLCOD[5]="autoRenewPeriod is expired";
 $POLLCOD[6]="Domain has been deleted";
 $POLLCOD[7]="No Registrar is expired";
 $POLLCOD[8]="Refund renew for deleting domain in autoRenewPeriod";
 $POLLCOD[9]="redemptionPeriod is started";
 $POLLCOD[10]="Domain transfer has been requested: pendingTransfer is started";
 $POLLCOD[11]="pendingUpdate is started";
 $POLLCOD[12]="Domain transfer is expired: transfer has been executed.You should therefore remove the records contained on your nameservers for such domain name.";
 $POLLCOD[13]="DNS check ended successfully with warning";
 $POLLCOD[14]="Domain transfer has been executed";
 $POLLCOD[15]="Debit renew for restoring expired domain in pendingDelete/redemptionPeriod";
 $POLLCOD[16]="Domain transfer is expired: transfer has been executed";
 $POLLCOD[17]="Domain transfer has been executed.You should therefore remove the records contained on your nameservers for such domain name.";
 $POLLCOD[18]="Domain and trade transfer has been requested: pendingTransfer is started";
 $POLLCOD[19]="Domain and trade transfer is expired: transfer has been executed";
 $POLLCOD[20]="Domain and trade transfer has been executed";
 $POLLCOD[21]="Domain and trade transfer has been executed.You should therefore remove the records contained on your nameservers for such domain name.";
 $POLLCOD[22]="redemptionPeriod is expired";
 $POLLCOD[23]="pendingUpdate is expired";
 $POLLCOD[24]="Refund renew for transferring and trading domain to a registrar in autoRenewPeriod";
 $POLLCOD[25]="Low credit will be reached soon";
 $POLLCOD[26]="Domain and trade transfer has been cancelled";
 $POLLCOD[27]="Domain and trade transfer is expired: transfer has been executed.You should therefore remove the records contained on your nameservers for such domain name.";
 $POLLCOD[28]="Command completed successfully; ack to dequeue";
 $POLLCOD[29]="Refund renew for autoRenewPeriod expired during pendingTransfer";
 $POLLCOD[30]="Password will expire soon";
 $POLLCOD[31]="Refund renew for transferring domain to a registrar in autoRenewPeriod";
?>