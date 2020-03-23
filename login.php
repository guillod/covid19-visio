<?php
$username = $_POST['username'];
$password = $_POST['password'];


$ldapconfig['host'] = 'localhost';//CHANGE THIS TO THE CORRECT LDAP SERVER
$ldapconfig['port'] = '3899';
$ldapconfig['basedn'] = 'dc=upmc,dc=fr';//CHANGE THIS TO THE CORRECT BASE DN
$ldapconfig['usersdn'] = 'ou=929,ou=UPMC,ou=Affectations';//CHANGE THIS TO THE CORRECT USER OU/CN
$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);

ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
ldap_set_option($ds, LDAP_OPT_NETWORK_TIMEOUT, 10);

$dn="uid=".$username.",".$ldapconfig['usersdn'].",".$ldapconfig['basedn'];
if(isset($_POST['username'])){
if ($bind=ldap_bind($ds, $dn, $password)) {
  echo("Login correct");
} else {

 echo "Login Failed: Please check your username or password";
}
}
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<form action="" method="post">
<input name="username">
<input type="password" name="password">
<input type="submit" value="Submit">
</form>
</body>
</html>
