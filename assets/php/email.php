<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$telefone			= $_POST["telefone"];	// Pega o valor do campo Telefone
$email				= $_POST["email"];	// Pega o valor do campo Email
$formato    		= $_POST["formato"];
$papelmiolo 		= $_POST["papelmiolo"];
$papeldecapa 		= $_POST["papeldecapa"];
$acabamentodecapa 	= $_POST["acabamentodecapa"];
$acabamentodolivro 	= $_POST["acabamentodolivro"];
$qtdpagcoloridas	= $_POST["qtdpagcoloridas"];
$qtdpagpretobranco	= $_POST["qtdpagpretobranco"];
$totpag				= $_POST["totpag"];
$tiragem			= $_POST["tiragem"];
$mensagem			= $_POST["mensagem"];	// Pega os valores do campo Mensagem
$arquivo   			= $_FILES["arquivo"];
$arquivo_nome 		= $arquivo['name']; // Recupera o nome do arquivo
$arquivo_caminho 	= $arquivo['tmp_name']; // Recupera o caminho temporario do arquivo no servidor
$data 				= date("d/m/Y H:i:s ");

// Variável que junta os valores acima e monta o corpo do email

$body  = '<html><body>';
$body .= '<table rules="all" style="border: bgcolor="#000000" frame="box"" cellpadding="10">';
$body .= '<tr><td bgcolor="#C0C0C0"><strong>Email:</strong> </td><td>' . $email . '</td></tr>';
$body .= '<tr><td bgcolor="#C0C0C0"><strong>Telefone:</strong> </td><td>' . $telefone . '</td></tr>';
$body .= '<tr><td bgcolor="#C0C0C0"><strong>Formato:</strong> </td><td>' . $formato . '</td></tr>';
$body .= '<tr><td bgcolor="#C0C0C0"><strong>Papel de Miolo:</strong> </td><td>' . $papelmiolo . '</td></tr>';
$body .= '<tr><td bgcolor="#C0C0C0"><strong>Papel de Capa:</strong> </td><td>' . $papeldecapa . '</td></tr>';
$body .= '<tr><td bgcolor="#C0C0C0"><strong>Acabamento de Capa:</strong> </td><td>' . $acabamentodecapa . '</td></tr>';
$body .= '<tr><td bgcolor="#C0C0C0"><strong>Acabamento do Livro:</strong> </td><td>' . $acabamentodolivro . '</td></tr>';
$body .= '<tr><td bgcolor="#C0C0C0"><strong>Quantidade de páginas coloridas:</strong> </td><td>' . $qtdpagcoloridas . '</td></tr>';
$body .= '<tr><td bgcolor="#C0C0C0"><strong>Quantidade de páginas preto e branco:</strong> </td><td>' . $qtdpagpretobranco . '</td></tr>';
$body .= '<tr><td bgcolor="#C0C0C0"><strong>Total de Páginas:</strong> </td><td>' . $totpag . '</td></tr>';
$body .= '<tr><td bgcolor="#C0C0C0"><strong>Tiragem:</strong> </td><td>' . $tiragem . '</td></tr>';
$body .= '<tr><td bgcolor="#C0C0C0"><strong>Mensagem:</strong> </td><td>' . $mensagem . '</td></tr>';
$body .= '<tr><td bgcolor="#C0C0C0"><strong>Enviado do site em:</strong> </td><td>' . $data . '</td></tr>';
$body .= '<tr><td bgcolor="#C0C0C0"><strong>Nome do Arquivo:</strong> </td><td>' . $arquivo_nome . '</td></tr>';
$body .= '</table>';
$body .= '</body></html>';
                
define('GUSER', 'noreplay.dooboks@gmail.com');	// <-- Insira aqui o seu GMail
define('GPWD', 's3nh@n0v@');		// <-- Insira aqui a senha do seu GMail
define('FROM_NAME', 'Produtora DuBooks');		// <-- Insira aqui a senha do seu GMail

function smtpmailer($para, $copia, $copiaoculta, $de, $de_nome, $assunto, $corpo,$arquivo_caminho,$arquivo_nome) { 
	global $error;
	$mail = new PHPMailer();
	$mail->isSMTP();

	//Enable SMTP debugging
	//SMTP::DEBUG_OFF = off (for production use)
	//SMTP::DEBUG_CLIENT = client messages
	//SMTP::DEBUG_SERVER = client and server messages
	$mail->SMTPDebug = SMTP::DEBUG_OFF;
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
	$mail->SMTPAutoTLS = false;

	$mail->Port = 587;

	//Set the encryption mechanism to use:
	// - SMTPS (implicit TLS on port 465) or
	// - STARTTLS (explicit TLS on port 587)
	$mail->SMTPSecure = 'tls';

	$mail->SMTPAuth = true;
	$mail->Username = GUSER;
	$mail->Password = GPWD;

	$mail->setFrom(GUSER, 'First Last');
	$mail->addReplyTo('fmmarmello@gmail.com', 'First Last');//responder para (email do usuario que enviou)
	$mail->addAddress($para, 'John Doe');//PARA
	// $mail->addCC($copia);
    // $mail->addBCC($copiaoculta);

	$mail->Subject = $assunto;

	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
	$mail->Body = $corpo;

	//Replace the plain text body with one created manually
	$mail->AltBody = 'Corpo alternativo';

	//Attach an image file
	$mail->addAttachment($arquivo_caminho,$arquivo_nome);

	//send the message, check for errors
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Mensagem enviada!';
		return true;
	}
}




// Insira abaixo o email que irá receber a mensagem, o email que irá enviar (o mesmo da variável GUSER), 
// o nome do email que envia a mensagem, o Assunto da mensagem e por último a variável com o corpo do email.

 //if (smtpmailer('matheuschabib@gmail.com', 'gushabib@live.com', 'gustavo@qrc.com.br', 'GUSER', 'Formulario do Site', 'DoBooks - Contato pelo site', $body)) {
 if (smtpmailer('fmmarmello@gmail.com', '', '', GUSER, FROM_NAME, 'DoBooks - Contato pelo site', $body,$arquivo_caminho,$arquivo_nome)) {

	Header("location: ../../index.html"); // Redireciona para uma página de obrigado.

}
//if (!empty($error)) echo $error;
?>