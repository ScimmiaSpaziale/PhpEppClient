<form method=POST action="scripts/registra_utente.php">
 <b>Nome</b> <input type=text size=60 name="NOME"> <br><br>
 <b>Cognome</b> <input type=text size=60 name="COGNOME"> <br><br>
 <b>E-Mail</b> <input type=text size=60 name="EMAIL"> <br><br>
 <b>Username</b> <input type=text size=60 name="USERNAME"> <br><br>
 <b>Password</b> <input type=password size=60 name="PASSWORD"> <br><br>
 <b>Tipo Utente</b> 
  <select class=select name="tipo" size=1>
   <option value="Admin">Admin</option>
   <option value="Gestore">Gestore</option>
   <option value="Generico">Utente</option>
  </select>
 <br><br>
 <b>Stato Utente</b> 
  <select class=select name="stato" size=1>
   <option value="Attivo">Attivo</option>
   <option value="Disattivato">Disattivato</option>
   <option value="Bloccato">Bloccato</option>
  </select>
 <br><br>
 <input type=submit name=S value="Registrami Adesso">
</form>
