

<?php
include('classInputform.php');


$inputForm = new Inputform('','POST', [], 'login123');
$inputForm->showFormIdOnEveryElement(true);
$inputForm->labelOpen('');
$login = $inputForm->addTextInput('login', true, ['class'=>'loginInput', 'placeholder'=>'Логин', 'maxlength'=>20], 'Введите логин!', 'Login', 'Некорректный логин!');
$inputForm->labelClose('');
$inputForm->labelOpen('');
$pass = $inputForm->addPasswordInput('password', true, ['class'=>'passwordInput', 'placeholder'=>'Пароль'], 'Введите пароль!', 'Password', 'Некорректный пароль!');
$passid = $inputForm->id;
$inputForm->labelClose('');
$inputForm->labelOpen('');
$pass2 = $inputForm->addPasswordInput('passwordConfirm', true, ['class'=>'passwordInput', 'placeholder'=>'Подтверждение пароля'], 'Введите подтверждение пароля!', 'Password', 'Некорректный пароль!', $passid, 'Пароли должны совпадать');
$inputForm->labelClose('');
$inputForm->labelOpen('');
$em = $inputForm->addEmailInput('userEmail', true, ['id'=>'email', 'placeholder'=>'E-mail'], 'Введите E-mail!', 'Email', 'Не корректный E-mail!');
$inputForm->labelClose('');
$tt = $inputForm->addCheckBox('remember', [ 'value'=>'23'], true, 'Поставь галочку', '<label>', '<span>Я согласен с правилами портала</span></label>');
$userName = $inputForm->addTextInput('userName', true, ['placeholder'=>'Ваше имя', 'maxlength'=>20]);
$userSurname = $inputForm->addTextInput('userSurname', true, ['placeholder'=>'Ваша фамилия', 'maxlength'=>30]);
$inputForm->addHtml('<fieldset>');
$radioGroup1 = $inputForm->addRadioButtonGroup('onetwo', true, 'Выберите один вариант!');
$radioGroup1Id = $inputForm->id;
$inputForm->addRadioToGroup($radioGroup1Id, 'первый', '<label>', 'первый</label>');
$inputForm->addRadioToGroup($radioGroup1Id, 'второй', '<label>', 'второй</label>');
$inputForm->addRadioToGroup($radioGroup1Id, 'третий', '<label>', 'третий</label>');
$inputForm->addRadioToGroup($radioGroup1Id, 'четвертый', '<label>', 'четвертый</label>');
$inputForm->addHtml('</fieldset>');
$select1 = $inputForm->addSelect('select1', true, true, [], 'Выберите что-нибудь!');
$select1Id = $inputForm->id;
$inputForm->addOptGroupToSelect($select1Id, 'Первая группа', []);
$select1group1Id = $inputForm->id;
$inputForm->addOptionToSelect($select1Id, 'Первый вариант', 'fg1', [], $select1group1Id);
$inputForm->addOptionToSelect($select1Id, 'Второй вариант', 'fg2', [], $select1group1Id);
$inputForm->addOptionToSelect($select1Id, 'Третий вариант', 'fg3', [], $select1group1Id);
$inputForm->addOptionToSelect($select1Id, 'Четвертый вариант', 'fg4');
$inputForm->addOptionToSelect($select1Id, 'Пятый вариант', 'ng1');
$inputForm->addOptionToSelect($select1Id, 'Шестой вариант', 'ng2');
$inputForm->addOptGroupToSelect($select1Id, 'Вторая группа');
$select1group2Id = $inputForm->id;
$inputForm->addOptionToSelect($select1Id, 'Седьмой вариант', 'sg1', [], $select1group2Id);
$inputForm->addOptionToSelect($select1Id, 'Восьмой вариант', 'sg2', [], $select1group2Id);
$textarea1 = $inputForm->addTextArea('textareaOne', ['maxlength'=>'30'], '', true, 'Введите!', 'Custom', 'Не менее 10 символа и не более 30!');
$textarea1Id = $inputForm->id;
$file1 = $inputForm->addFileInput('fileOne', ['accept'=>'image/*'], 31457280, true, 'FILE!', './downloads/');
$file1Id = $inputForm->id;
$inputForm->addHtml('<div class="tinyBtn">');
$btn1 = $inputForm->addButton('submit', '✔', ['name'=>'subm', 'value'=>'ok']);
$btn2 = $inputForm->addButton('reset', '✖', ['name'=>'reset', 'value'=>'popo']);
$inputForm->addHtml('</div>');
$last = $inputForm->id;
$inputForm->requiredText = '';







if($inputForm->noErrors && $inputForm->formSended){
	//$inputForm->clearAllValues();
} 


$loginForm = $inputForm->returnFullHtml();
//var_dump($pass, $pass2);
//var_dump($file1);
//var_dump($inputForm->formContent[$file1Id]);

//echo Inputform::tagsToHTML(['hey'=>'Привет']) . '<br>';
//var_dump($_FILES);
//var_dump($_REQUEST);
?>








<!DOCTYPE html>
<html>
	<head>
		<style>
			body {
				background:#CCEFFF;;
				color : #000;;
			}
			#login123 {
				background: antiquewhite;
				width: 147px;
				margin: 0 auto;
			}
			#login123 .formElement {
				position:relative;
				margin-bottom: 10px;
			}
			.requiredError, .validateError {
				position: absolute;
				top: 0px;
				background: #ff7b7b;
				color: white;
				padding: 0px 5px 2px 5px;
				border-radius: 5px;
				left: 148px;
				white-space: nowrap;
				border: 1px solid white;
				font-size: 12px;
			}
			.requiredError:before, .validateError:before{
				content: '';
				border: 6px solid transparent;
				position: absolute;
				border-right: 6px solid red;
				left: -13px;
				top: 4px;
			}
			.requiredError ~ input, .validateError ~ input{
				border: 1px solid red;
				padding: 2px;
			}
			.remCheckbox{
				margin-bottom: 10px;
				display: block;
				line-height: 14px;
			}
			.remCheckbox input[type="checkbox"]{
				margin: 0px 3px 0px 0px;
			}
			#login123 .remCheckbox .formElement{
				display: inline-block;
				margin: 0;
			}
			.remCheckbox .requiredError, .remCheckbox .validateError{
				top: -6px;
				right: 20px;
				left: unset;
			}
			.remCheckbox .requiredError:before, .remCheckbox .validateError:before{
				border-right: transparent;
				border-left: 6px solid red;
				left: 101%;
			}
			#login123 .radioButtonsGroup input[type="radio"]{
				margin: 0px 3px 0px 0px;
				position: relative;
				top: 2px;
			}
			#login123 .radioButtonsGroup label{
				display: block;
			}
			#login123 .tinyBtn .formElement{
				display:inline-block;
				margin-bottom: 0;
			}
			#login123 fieldset{
				padding: 0px;
			}
			.formElement>.formSelect select{
				width: 147px;
			}
			.formElement textarea{
				resize: none;
				width: 147px;
			}
			.formElement input[type="file"]{
				background: #9de1a1;
				width: 145px;
			}
			
		</style>
	</head>
	<body>
			<?= $loginForm ?>


	</body>
</html>
