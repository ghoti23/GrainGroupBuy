<?php   require 'dao/dao.php';
        require 'entity/user.php';
        require 'properties.php';
        require 'Mandrill.php';

$email = strip_tags($_REQUEST["email"]);

if ($email != "") {
	$dao = new dao();
	$dao->connect($host,$pdo);
	$user=$dao->loadUser($email);
	// The message
	$link = "http://artofbeerbrewery.com/groupbuy/resetPassword.php?email=".$email."&id=" . $user->getPassword();



    $mandrill = new Mandrill('AFkXcZ94ZLRKkvpEoBEDMA');

    $params = array(
        'subject' => 'Reset Password',
        'from_email' => 'admin@artofbeerbrewery.com',
        'to' => array(array('email' => $user->getEmail())),
        'merge_vars' => array(array(
            'rcpt' => $user->getEmail(),
            'vars' =>
            array(
                array(
                    'name' => 'link',
                    'content' => $link))
            )));

    $template_name = 'reset-password';

    $template_content = array();

    $response = $mandrill->messages->sendTemplate($template_name, $template_content, $params);
    print_r($result);
}
?>
