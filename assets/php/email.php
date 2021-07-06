<?
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
$file   			= $_FILES["file"];
$data 				= date("d/m/Y H:i:s ");

// Variável que junta os valores acima e monta o corpo do email

		$Vai  = '<html><body>';
		$Vai .= '<table rules="all" style="border: bgcolor="#000000" frame="box"" cellpadding="10">';
		$Vai .= '<tr><td bgcolor="#C0C0C0"><strong>Email:</strong> </td><td>' . $email . '</td></tr>';
		$Vai .= '<tr><td bgcolor="#C0C0C0"><strong>Telefone:</strong> </td><td>' . $telefone . '</td></tr>';
		$Vai .= '<tr><td bgcolor="#C0C0C0"><strong>Formato:</strong> </td><td>' . $formato . '</td></tr>';
		$Vai .= '<tr><td bgcolor="#C0C0C0"><strong>Papel de Miolo:</strong> </td><td>' . $papelmiolo . '</td></tr>';
		$Vai .= '<tr><td bgcolor="#C0C0C0"><strong>Papel de Capa:</strong> </td><td>' . $papeldecapa . '</td></tr>';
		$Vai .= '<tr><td bgcolor="#C0C0C0"><strong>Acabamento de Capa:</strong> </td><td>' . $acabamentodecapa . '</td></tr>';
		$Vai .= '<tr><td bgcolor="#C0C0C0"><strong>Acabamento do Livro:</strong> </td><td>' . $acabamentodolivro . '</td></tr>';
		$Vai .= '<tr><td bgcolor="#C0C0C0"><strong>Quantidade de páginas coloridas:</strong> </td><td>' . $qtdpagcoloridas . '</td></tr>';
		$Vai .= '<tr><td bgcolor="#C0C0C0"><strong>Quantidade de páginas preto e branco:</strong> </td><td>' . $qtdpagpretobranco . '</td></tr>';
		$Vai .= '<tr><td bgcolor="#C0C0C0"><strong>Total de Páginas:</strong> </td><td>' . $totpag . '</td></tr>';
		$Vai .= '<tr><td bgcolor="#C0C0C0"><strong>Tiragem:</strong> </td><td>' . $tiragem . '</td></tr>';
		$Vai .= '<tr><td bgcolor="#C0C0C0"><strong>Mensagem:</strong> </td><td>' . $mensagem . '</td></tr>';
		$Vai .= '<tr><td bgcolor="#C0C0C0"><strong>Enviado do site em:</strong> </td><td>' . $data . '</td></tr>';
		$Vai .= '</table>';
		$Vai .= '</body></html>';
                
                
require_once("./phpmailer/class.phpmailer.php");

define('GUSER', 'noreplay.dooboks@gmail.com');	// <-- Insira aqui o seu GMail
define('GPWD', 's3nh@n0v@');		// <-- Insira aqui a senha do seu GMail

function smtpmailer($para, $copia, $copiaoculta, $de, $de_nome, $assunto, $corpo) { 
	global $error;
	$mail = new PHPMailer();
	$mail->IsSMTP();		// Ativar SMTP
	$mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
	$mail->SMTPAuth = true;		// Autenticação ativada
	$mail->SMTPSecure = 'ssl';	// SSL REQUERIDO pelo GMail
	$mail->Host = 'smtp.gmail.com';	// SMTP utilizado
	$mail->Port = 465;  		// A porta 465 deverá estar aberta em seu servidor
	$mail->Username = GUSER;
	$mail->Password = GPWD;
	$mail->SetFrom($de, $de_nome);
	$mail->Subject = $assunto;
	$mail->Body = $corpo;
	$mail->AddAddress($para);
	$mail->AddBcc($copia);
	$mail->AddCc($copiaoculta);
	$mail->AddAttachment($arquivo['tmp_name'], $arquivo['name']  ); //anexando arquivo
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

 if (smtpmailer('matheuschabib@gmail.com', 'noreplay.dooboks@gmail.com', 'contato@posprint.com.br', 'GUSER', 'Formulario do Site', 'DoBooks - Contato pelo site', $Vai)) {

	Header("location: index.html"); // Redireciona para uma página de obrigado.

}
if (!empty($error)) echo $error;
?>