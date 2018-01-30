

<?php
echo '<pre>';
class form {
	private $formId = '';
	private $formSended = false;
	private $action = '';
	private $method = '';
	private $tags = [];
	private $showIdOnEveryElement = '';
	public $id = 0;
	public $callbackFunction;
	public $formContent=[];
	public $validateLoginRegEx = '#(?!(?:^\d*$)|.{21})^[a-z0-9]{1}(?:[a-z0-9]|(?:[-](?!(?:-)|(?:_)))|(?:[_](?!(?:-)|(?:_))))+[a-z0-9]{1}$#i';
	public $validatePasswordRegEx = '#^[^а-я]{6,30}$#iu';
	public $noErrors = true;
	private $showValues=true;
	function __construct($action='', $method='GET', $tags=[], $formId='form'){
		$this->action = $action;
		$this->method = $method;
		$tagsArr = [];
		foreach($tags as $tag=>$val){
			$tagsArr[$tag]=$val;
		}
		$this->tags = $tagsArr;
		$this->formId = $formId;
		if(isset($_REQUEST[$formId]) && $_REQUEST[$formId]==='s'){
			$this->formSended = true;
		}
	}
	public function showIdOnEveryElement($show=false){
		if($show === true){
			$this->showIdOnEveryElement = ' form="'.$this->formId.'" ';
		}
	}
	private function setId(){
		$this->id++;
		return $this->id;
	}
	public function validateLogin($str){
		$RegEx = $this->validateLoginRegEx;
		if(preg_match($RegEx,$str)===1){return true;}
		return false;
	}
	public function validatePassword($str){
		$RegEx = $this->validatePasswordRegEx;
		if(preg_match($RegEx,$str)===1){return true;}
		return false;
	}
	public function validateEmail($str){
		return filter_var($str, FILTER_VALIDATE_EMAIL);
	}
	public function clearAllValues(){
		$this->showValues=false;
		/////Сделать: нормальную отчистку!!(чекбоксы и радио )
		foreach($this->formContent as $id=>$optionsArray){
			$type = $optionsArray['type'];
			if($type==='text' || $type==='password' || $type==='email'){
				unset($this->formContent[$id]['tags']['value']);
			} elseif ($type==='checkbox'){
				unset($this->formContent[$id]['tags']['checked']);
			} elseif ($type==='radioGroup'){
				foreach($optionsArray['buttons'] as $key=>$arr){
					unset($this->formContent[$id]['buttons'][$key]['tags']['checked']);
				}
			}
		}
	}
	public function tagsToHTML($tags=[]){
		$result = '';
		foreach($tags as $tag=>$val){
			$result .= ' '.$tag.'="'.$val.'" ';
		}
		return $result;
	}
	public function formOpenHtml(){
		$tempStr = '<form action="'.$this->action.'" method="'.$this->method.'" ';
		$tempStr .= $this->tagsToHTML($this->tags);
		$tempStr .= ' id="'.$this->formId.'">';
		return $tempStr;
	}
	public function formCloseHtml(){
		$tempStr = '<input type="hidden" name="'.$this->formId.'" value="s">';
		$tempStr .= '</form>';
		return $tempStr;
	}
	public function addHtml($HTML=''){
		$id = $this->setId();
		$this->formContent[$id]['type'] = 'pureHtml';
		$this->formContent[$id]['content'] = $HTML;
	}
	public function labelOpen ($HTMLcontent='', $tags=[]){
		$id = $this->setId();
		$this->formContent[$id]['type'] = 'labelOpen';
		$this->formContent[$id]['tags'] = $tags;
		$this->formContent[$id]['HTMLcontent'] = $HTMLcontent;
	}
	public function labelClose($HTMLcontentBeforeClose = ''){
		$id = $this->setId();
		$this->formContent[$id]['type'] = 'labelClose';
		$this->formContent[$id]['HTMLcontentBeforeClose'] = $HTMLcontentBeforeClose;
	}
	public function addTextInput($tagName, $saveFormValue = false, $tags=[], $required = false, $validate=false, $validateErrorMessage='Поле заполнено неверно', $type='text'){
		$id = $this->setId();
		if($type !== 'password' && $type !== 'text' && $type !== 'email'){
			$type = 'text';
		}
		$this->formContent[$id]['type'] = $type;
		$this->formContent[$id]['tagName'] = $tagName;
		$returnValue = false;
		if($this->formSended){
			$returnValue = $_REQUEST[$tagName];
		}
		if($saveFormValue){
			if($this->formSended){
				$tags['value']=$_REQUEST[$tagName];
			}
		}
		if($required !== false){
			$this->formContent[$id]['requiredMessage'] = $required;
			if($this->formSended && empty($_REQUEST[$tagName])){
				$this->formContent[$id]['requiredError'] = true;
				$returnValue = false;
				$this->noErrors = false;
			} else {
				$this->formContent[$id]['requiredError'] = false;
			}
		}
		if($validate !== false){
			$this->formContent[$id]['validateMessage'] = $validateErrorMessage;
			$this->formContent[$id]['validateError'] = false;
			if ($returnValue !== false){
				if(!$this->{'validate'.$validate}($returnValue)){
					$this->formContent[$id]['validateError'] = true;
					$returnValue = false;
					$this->noErrors = false;
				}
			}
		}
		$this->formContent[$id]['tags'] = $tags;
		if($type === 'password' || $type === 'email'){
			$returnValue = ['id'=>$id, 'value'=>$returnValue];
		}
		return $returnValue;
	}
	public function addPasswordInput($tagName, $saveFormValue = false, $tags=[], $required = false, $validate=false, $validateErrorMessage='Поле заполнено неверно', $passNeedСonfirm = false, $passConfirmMesssage='Пароли не совпадают!'){
		$retArr = $this->addTextInput($tagName, $saveFormValue, $tags, $required, $validate, $validateErrorMessage, 'password');
		
		$id = $retArr['id'];
		
		$pass = $retArr['value'];
		if($passNeedСonfirm !== false){
			$confirmPassId = $passNeedСonfirm;
			$confirmPassTagName = $this->formContent[$confirmPassId]['tagName'];
			$notEntered = $this->formContent[$id]['requiredError'] || $this->formContent[$confirmPassId]['requiredError'];
			//$notValidated = $this->formContent[$name]['validateError'] || $this->formContent[$passNeedСonfirm]['validateError'];
			if(!$notEntered && $this->formSended){
				if($_REQUEST[$confirmPassTagName] != $_REQUEST[$tagName]){
					$this->formContent[$id]['validateError'] = true;
					$this->formContent[$id]['validateMessage'] = $passConfirmMesssage;
					$this->formContent[$confirmPassId]['validateError'] = true;
					$this->formContent[$confirmPassId]['validateMessage'] = $passConfirmMesssage;
					$pass = false;
					$this->noErrors = false;
				}
			}
		}
		return $pass;
	}
	public function addCheckBox($tagName, $tags=[], $saveFormValue = false, $required = false){
		$id = $this->setId();
		$this->formContent[$id]['tagName'] = $tagName;
		$this->formContent[$id]['type'] = 'checkbox';
		$returnValue = false;
		if($this->formSended){
			if(isset($_REQUEST[$tagName])){
				$returnValue = $_REQUEST[$tagName];
			} else {
				$returnValue = false;
			}
		}
		if($saveFormValue !== false){
			if($returnValue !== false){
				$tags['checked'] = '';
			} elseif ($this->formSended){
				unset($tags['checked']);
			}
		}
		if($required !== false){
			$this->formContent[$id]['requiredMessage'] = $required;
			$this->formContent[$id]['requiredError'] = false;
			if($this->formSended && $returnValue === false){
				$this->formContent[$id]['requiredError'] = true;
				$this->noErrors = false;
			}
		}
		$this->formContent[$id]['tags'] = $tags;
		return $returnValue;
	}
	public function addRadioButtonGroup($radioNames, $saveFormValue = true, $required = true){
		$id = $this->setId();
		$this->formContent[$id]['type'] = 'radioGroup';
		$this->formContent[$id]['names'] = $radioNames;
		$this->formContent[$id]['buttons'] = [];
		$this->formContent[$id]['saveFormValue'] = $saveFormValue;
		$returnValue = false;
		if($this->formSended){
			if(isset($_REQUEST[$radioNames]) && $_REQUEST[$radioNames] !== ''){
				$returnValue = $_REQUEST[$radioNames];
			} else {
				$returnValue = false;
			}
		}
		if($required){
			$this->formContent[$id]['requiredMessage'] = $required;
			$this->formContent[$id]['requiredError'] = false;
			if($this->formSended && $returnValue === false){
				$this->formContent[$id]['requiredError'] = true;
				$returnValue = false;
				$this->noErrors = false;
			}
		}
		$this->formContent[$id]['returnValue'] = $returnValue;
		return $returnValue;
	}
	public function addButton($btnType, $HTMLcontent, $tags=[]){
		$id = $this->setId();
		$this->formContent[$id]['type'] = 'button';
		$this->formContent[$id]['btnType'] = $btnType;
		$this->formContent[$id]['HTMLcontent'] = $HTMLcontent;
		$this->formContent[$id]['tags'] = $tags;
	}
	private function saveValuesRadioGroup($id){
		foreach($this->formContent[$id]['buttons'] as $key=>$button){
			if($this->formContent[$id]['returnValue'] == $button['value']){
				$this->formContent[$id]['buttons'][$key]['tags']['checked']='';
			} else {
				unset($this->formContent[$id]['buttons'][$key]['tags']['checked']);
			}
		}
	}
	public function addRadioToGroup($groupId, $value, $htmlBefore='', $htmlAfter='', $tags=[]){
		$id = $this->setId();
		$this->formContent[$groupId]['buttons'][$id]['value'] = $value;
		$this->formContent[$groupId]['buttons'][$id]['htmlBefore'] = $htmlBefore;
		$this->formContent[$groupId]['buttons'][$id]['htmlAfter'] = $htmlAfter;
		$this->formContent[$groupId]['buttons'][$id]['tags'] = $tags;
	}
	public function addEmailInput($tagName, $saveFormValue=false, $tags=[], $required=false, $validate=false, $validateErrorMessage='Не корректный E-mail!'){
		$retArr = $this->addTextInput($tagName, $saveFormValue, $tags, $required, $validate, $validateErrorMessage, $type='email');
		$id = $retArr['id'];
		$email = $retArr['value'];
		return $email;
	}
	//функции возврата HTML↓
	public function returnButtonHtml($id){
		$tempStr = '<div class="formElement">';
		$tempStr .= '<button type="'.$this->formContent[$id]['btnType'].'" ';
		$tempStr .= $this->showIdOnEveryElement;
		$tempStr .= $this->tagsToHTML($this->formContent[$id]['tags']);
		$tempStr .= '>';
		$tempStr .= $this->formContent[$id]['HTMLcontent'];
		$tempStr .= '</button></div>';
		return $tempStr;
	}
	public function returnRadioGroupHtml($id){
		if($this->formContent[$id]['saveFormValue'] === true && $this->formSended && $this->formContent[$id]['returnValue'] !== false && $this->showValues){
			$this->saveValuesRadioGroup($id);
		}
		$opt = $this->formContent[$id];
		$tempStr = '<div class="formElement"><div class="radioButtonsGroup">';
		if(isset($opt['requiredError']) && $opt['requiredError']){
			$tempStr .= '<div class="requiredError">'.$opt['requiredMessage'].'</div>';
		}
		foreach($opt['buttons'] as $key=>$arrayValue){
			$tempStr .= $arrayValue['htmlBefore'];
			$tempStr .= '<input type="radio" name="'.$opt['names'].'" value="'.$arrayValue['value'].'" '.$this->showIdOnEveryElement;
			$tempStr .= $this->tagsToHTML($arrayValue['tags']);
			$tempStr .= '>';
			$tempStr .= $arrayValue['htmlAfter'];
		}
		$tempStr .= '</div></div>';
		return $tempStr;
	}
	public function returnCheckBoxHtml($id){
		$opt = $this->formContent[$id];
		$tempStr = '<div class="formElement">';
		if(isset($opt['requiredError']) && $opt['requiredError']){
			$tempStr .= '<div class="requiredError">'.$opt['requiredMessage'].'</div>';
		}
		$tempStr .= '<input type="checkbox" name="'.$opt['tagName'].'" '.$this->showIdOnEveryElement;
		$tempStr .= $this->tagsToHTML($opt['tags']);
		$tempStr .= '></div>';
		return $tempStr;
	}
	public function returnTextInputHtml($id, $type='text'){
		$options = $this->formContent[$id];
		$tempStr = '<div class="formElement">';
		if(isset($options['requiredError']) && $options['requiredError']){
			$tempStr .= '<div class="requiredError">'.$options['requiredMessage'].'</div>';
		}
		if(isset($options['validateError']) && $options['validateError']){
			$tempStr .= '<div class="validateError">'.$options['validateMessage'].'</div>';
		}
		if($type !== 'password' && $type !== 'text' && $type !== 'email'){
			$type = 'text';
		}
		$tempStr .= '<input type="'.$type.'" name="'.$options['tagName'].'" '.$this->showIdOnEveryElement;
		$tempStr .= $this->tagsToHTML($options['tags']);
		$tempStr .= '></div>';
		return $tempStr;
	}
	public function returnPasswordInputHtml($id){
		$tempStr = $this->returnTextInputHtml($id, 'password');
		return $tempStr;
	}
	public function returnEmailInputHtml($id){
		$tempStr = $this->returnTextInputHtml($id, 'email');
		return $tempStr;
	}
	public function labelOpenHtml($id){
		$tempStr = '<label ';
		$tempStr .= $this->tagsToHTML($this->formContent[$id]['tags']);
		$tempStr .= '>'.$this->formContent[$id]['HTMLcontent'];
		return $tempStr;
	}
	public function labelCloseHtml($id){
		$tempStr =''.$this->formContent[$id]['HTMLcontentBeforeClose'].'</label>';
		return $tempStr;
	}
	public function returnHtmlbyId($id){
		$tempStr = '';
		$tempStr2 = '';
		switch ($this->formContent[$id]['type']) {
			case 'text':
				$tempStr .= $this->returnTextInputHtml($id);
				break;
			case 'password':
				$tempStr .= $this->returnPasswordInputHtml($id);
				break;
			case 'labelOpen':
				$tempStr .= $this->labelOpenHtml($id);
				break;
			case 'labelClose':
				$tempStr .= $this->labelCloseHtml($id);
				break;
			case 'pureHtml':
				$tempStr .= ' '.$this->formContent[$id]['content'].' ';
				break;
			case 'checkbox':
				$tempStr .= $this->returnCheckBoxHtml($id);
				break;
			case 'email':
				$tempStr .= $this->returnEmailInputHtml($id);
				break;
			case 'radioGroup':
				$tempStr .= $this->returnRadioGroupHtml($id);
				break;
			case 'button':
				$tempStr .= $this->returnButtonHtml($id);
				break;
			
		}
		return $tempStr;
	}
	public function returnFullHtml(){
		$returnHtml = $this->formOpenHtml();
		foreach($this->formContent as $id=>$inpArr){
			$returnHtml .= $this->returnHtmlbyId($id);
		}
		$returnHtml .= $this->formCloseHtml();
		return $returnHtml;
	}
	//функции возврата HTML↑
}

$inputForm = new form('','POST', [], 'login123');
$inputForm->showIdOnEveryElement(false);
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
$inputForm->labelOpen('', ['class'=>'remCheckbox']);
$tt = $inputForm->addCheckBox('remember', ['checked'=>'', 'value'=>'23'], true, 'Поставь галочку');
$inputForm->labelClose('<span>Я согласен с правилами портала</span>');
$userName = $inputForm->addTextInput('userName', true, ['placeholder'=>'Ваше имя', 'maxlength'=>20]);
$userSurname = $inputForm->addTextInput('userSurname', true, ['placeholder'=>'Ваша фамилия', 'maxlength'=>30]);
$inputForm->addHtml('<fieldset><legend>Выберите что нибудь</legend>');
$radioGroup1 = $inputForm->addRadioButtonGroup('onetwo', true, 'Выберите один вариант!');
$radioGroup1Id = $inputForm->id;
$inputForm->addRadioToGroup($radioGroup1Id, 'первый', '<label>', 'первый</label>');
$inputForm->addRadioToGroup($radioGroup1Id, 'второй', '<label>', 'второй</label>');
$inputForm->addRadioToGroup($radioGroup1Id, 'третий', '<label>', 'третий</label>');
$inputForm->addRadioToGroup($radioGroup1Id, 'четвертый', '<label>', 'четвертый</label>');
$inputForm->addHtml('</fieldset>');
$inputForm->addHtml('<div class="tinyBtn">');
$inputForm->addButton('submit', '✔', ['name'=>'subm', 'value'=>'ok']);
$inputForm->addButton('reset', '✖', ['name'=>'reset', 'value'=>'popo']);
$inputForm->addHtml('</div>');
//var_dump($inputForm->formContent);




var_dump($_POST);






if($inputForm->noErrors){
	$inputForm->clearAllValues();
} 


$loginForm = $inputForm->returnFullHtml();





echo '</pre>';
?>








<!DOCTYPE html>
<html>
	<head>
		<style>
			body {
				background:#CCCCFF;
				color : #0030FF;
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
				//display: none;
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
			
		</style>
	</head>
	<body>
			<?= $loginForm ?>
			<button type="submit" form="login" >отправить</button>
			<meter value=".8" low=".25" high=".75" optimum=".2"></meter>
			<progress value="0.75">Выполнено 75% работы</progress>
			<select name="s3" size="2">
				<optgroup label="HTML">
					<optgroup label="HdTML">
						<option value="h3">HTML3.2</option>
						<option value="h4">HTML4.0</option>
						<option value="h5">HTML5</option>
					</optgroup>
					<optgroup label="HdTMdL">
						<option value="h3">HTML3.2</option>
						<option value="h4">HTML4.0</option>
						<option value="h5">HTML5</option>
					</optgroup>
					<option value="h3">HTML3.2</option>
					<option value="h4">HTML4.0</option>
					<option value="h5">HTML5</option>
				</optgroup>
				<optgroup label="CSS">
					<option value="css1">CSS1</option>
					<option value="css2">CSS2</option>
					<option value="css3">CSS3</option>
				</optgroup>
				<option value="js">JavaScript</option>
				<option value="dhtml">DHTML</option>
			</select>
	</body>
</html>
