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

 global $db_host,$db_user,$db_password,$db_name,$db,$db_reconnect;

 $db="";
 $db_host="frazionabile.it";
 $db_user="root";
 $db_password="CGPT88AAXYZ";
 $db_name="platform_hosting";

 ########################################################################
 # Alcuni server perdono la connessione MySQL dopo poche query, se il   #
 # vostro server si comporta in questo modo, allora mettete questa      #
 # variabile a TRUE, verrà ricreata una connessione per ogni query,     #
 # altrimenti lasciate su FALSE;                                        #
 ########################################################################

 $db_reconnect=FALSE;
?>
