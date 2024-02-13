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
 # giovanni.ceglia@frazionabile.it or giovanniceglia@xungame.com              #
 #                                                                      #
 ########################################################################

 ########################################################################
 # Funzioni aggiornate 10/09/2010
 ########################################################################

 function print_debug_info($XML,$TEXTAREANAME,$COLS,$ROWS,$RESCODE,$REASONCODE,$ID_EPPSESSION){
  global $LANGUAGE;
  $DEBUG=is_debug_on();
  if ($DEBUG) {
   echo "<br><br>"; 
   print_xml_textarea($XML,$TEXTAREANAME,$COLS,$ROWS);
   echo "<br><br>"; 
   if ($RESCODE!="") echo "<b>$LANGUAGE[384]</b> $RESCODE <br>";
   if ($REASONCODE!="") echo "<b>$LANGUAGE[385]</b> $REASONCODE <br>";
   echo "$LANGUAGE[386] <b>$ID_EPPSESSION</b><br>";
  }
 }

 function print_debug_info_polling($XML,$TEXTAREANAME,$COLS,$ROWS,$RESCODE,$REASONCODE,$ID_EPPSESSION){
  global $LANGUAGE;
  $DEBUG=is_debug_on();
  if ($DEBUG) {
   echo "<br><br>"; 
   print_xml_textarea($XML,$TEXTAREANAME,$COLS,$ROWS);
   echo "<br><br>"; 
   if ($RESCODE!="") echo "<b>$LANGUAGE[384]</b> $RESCODE <br>";
   if ($REASONCODE!="") echo "<b>$LANGUAGE[385]</b> $REASONCODE <br>";
   echo "$LANGUAGE[386] <b>$ID_EPPSESSION</b><br>";
   xml_domain_polling_msg($XML,$QT,$IDMSG,$DATA,$MSG,$DOMAIN);
   if ($RESCODE==1301) {
    echo "
     $LANGUAGE[391] <b>$IDMSG</b>, 
     $LANGUAGE[392] <b>$QT</b>, 
     $LANGUAGE[393] <b>$DATA</b>, 
     $LANGUAGE[394] <b>$MSG</b>.
    ";
   }
  }
 }

 ########################################################################
 # Funzioni aggiornate 10/10/2009
 ########################################################################

 function print_xml_textarea($XML,$NAME,$NCOL,$NROW){
  echo "<textarea name=\"$NAME\" cols=\"$NCOL\" rows=\"$NROW\">$XML</textarea><br>";
 }
 
 function print_epp_error($RESCODE,$REASONCODE){
  global $EPPERR,$EPPREA,$EPPGEN;
  if ($REASONCODE>=9000) echo "<b>$EPPGEN[9000]</b>: $EPPERR[$RESCODE], $EPPREA[$REASONCODE].";
   else if ($REASONCODE>=8000) echo "<b>$EPPGEN[8000]</b>: $EPPERR[$RESCODE], $EPPREA[$REASONCODE]";
    else if ($REASONCODE>=7000) echo "<b>$EPPGEN[7000]</b>: $EPPERR[$RESCODE], $EPPREA[$REASONCODE]";
    else if ($REASONCODE>=6000) echo "<b>$EPPGEN[6000]</b>: $EPPERR[$RESCODE], $EPPREA[$REASONCODE]";
    else if ($REASONCODE>=5000) echo "<b>$EPPGEN[5000]</b>: $EPPERR[$RESCODE], $EPPREA[$REASONCODE]";
    else if ($REASONCODE>=4000) echo "<b>$EPPGEN[4000]</b>: $EPPERR[$RESCODE], $EPPREA[$REASONCODE]";
    else if (($RESCODE>=1000) && ($RESCODE<2000)) echo "<b>$EPPGEN[1000]</b>: $EPPERR[$RESCODE]";
  else {
   echo "<b>$EPPGEN[1]</b>: $EPPERR[$RESCODE]";
   if ($REASONCODE!="") echo ", $REASONCODE";
   echo ".";
  }
 }
?>