

<?php
echo '<pre>';
class Inputform {
	private $formId = '';
	public $formSended = false;
	private $action = '';
	private $method = '';
	private $formEnctype = 'application/x-www-form-urlencoded';
	private $tags = [];
	private $showFormIdOnEveryElement = '';
	public $id = 0;
	public $requiredText = ' required ';
	public $callbackFunction;
	public $formContent=[];
	public $validateLoginRegEx = '#(?!(?:^\d*$)|.{21})^[a-z0-9]{1}(?:[a-z0-9]|(?:[-](?!(?:-)|(?:_)))|(?:[_](?!(?:-)|(?:_))))+[a-z0-9]{1}$#i';
	public $validatePasswordRegEx = '#^[^а-я]{6,30}$#iu';
	public $validateCustomRegEx = '#^.{10,30}$#iu';
	public $noErrors = true;
	private $showValues=true;
	function __construct($action='', $method='GET', $tags=[], $formId='form', $enctype = 'application/x-www-form-urlencoded'){
		$this->action = $action;
		$this->method = $method;
		$this->formEnctype = $enctype;
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
	public function showFormIdOnEveryElement($show=false){
		if($show === true){
			$this->showFormIdOnEveryElement = ' form="'.$this->formId.'" ';
		}
	}
	private function setId(){
		$this->id++;
		return $this->id;
	}
	public function validateCustom($str){
		$RegEx = $this->validateCustomRegEx;
		if(preg_match($RegEx,$str)===1){return true;}
		return false;
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
			} elseif ($type==='select'){
				foreach($optionsArray['options'] as $selKey=>$selOpt){
					if($selOpt['type'] == 'selOptGr'){
						foreach($selOpt['options'] as $selKey2 => $selOpt2){
							unset($this->formContent[$id]['options'][$selKey]['options'][$selKey2]['tags']['selected']);
						}
					} elseif($selOpt['type'] == 'option'){
						unset($this->formContent[$id]['options'][$selKey]['tags']['selected']);
					}
				}
			}
		}
	}
	static function tagsToHTML($tags=[]){
		$result = '';
		foreach($tags as $tag=>$val){
			$result .= ' '.$tag.'="'.$val.'" ';
		}
		return $result;
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
		if($this->formSended && isset($_REQUEST[$tagName])){
			$returnValue = $_REQUEST[$tagName];
		}
		if($saveFormValue){
			if($this->formSended && isset($_REQUEST[$tagName])){
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
			if(isset($_REQUEST[$radioNames])){
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
		if(isset($tags['name']) && isset($tags['value'])){
			if($this->formSended && isset($_REQUEST[$tags['name']]) && $_REQUEST[$tags['name']] == $tags['value']){
				return $_REQUEST[$tags['name']];
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
	public function addSelect ($tagName, $isMultiple = true, $saveFormValue=false, $tags=[], $required=false){
		$id = $this->setId();
		$this->formContent[$id]['type'] = 'select';
		$tagName = str_replace(['[', ']'], ['', ''], $tagName);
		$this->formContent[$id]['tagName'] = $tagName;
		$this->formContent[$id]['isMultiple'] = $isMultiple;
		$this->formContent[$id]['saveFormValue'] = $saveFormValue;
		$this->formContent[$id]['tags'] = $tags;
		$returnValue = false;
		if($this->formSended && isset($_REQUEST[$tagName]) && !empty($_REQUEST[$tagName])){
			$returnValue = $_REQUEST[$tagName];
		}
		if($required !== false){
			$this->formContent[$id]['requiredMessage'] = $required;
			if($this->formSended && $returnValue===false){
				$this->formContent[$id]['requiredError'] = true;
				$this->noErrors = false;
			}
		}
		$this->formContent[$id]['options'] = [];
		return $returnValue;
	}
	public function addOptGroupToSelect($selectId, $label, $tags=[]){
		$id = $this->setId();
		$this->formContent[$selectId]['options'][$id]['type'] = 'selOptGr';
		$this->formContent[$selectId]['options'][$id]['label'] = $label;
		$this->formContent[$selectId]['options'][$id]['tags'] = $tags;
		$this->formContent[$selectId]['options'][$id]['options'] = [];
	}
	public function addOptionToSelect($selectId, $text, $value, $tags=[], $addToOptGroupId=false){
		$id = $this->setId();
		$parent =& $this->formContent[$selectId]['options'];
		if($addToOptGroupId !== false){
			$parent =& $this->formContent[$selectId]['options'][$addToOptGroupId]['options'];
		}
		$parent[$id]['type'] = 'option';
		$parent[$id]['text'] = $text;
		$parent[$id]['value'] = $value;
		$parent[$id]['tags'] = $tags;
	}
	public function addTextArea($tagName, $tags=[], $text='', $saveFormValue=false, $required=false, $validate=false, $validateErrorMessage='Неверные данные!'){
		$id = $this->setId();
		$returnValue = false;
		$this->formContent[$id]['type']= 'textarea';
		$this->formContent[$id]['tagName']= $tagName;
		$this->formContent[$id]['text']= $text;
		if($this->formSended && isset($_REQUEST[$tagName])){
			$returnValue = $_REQUEST[$tagName];
		}
		if($saveFormValue !== false){
			if($returnValue !== false){
				$this->formContent[$id]['text'] = $_REQUEST[$tagName];
			}
		}
		if($required !== false){
			$this->formContent[$id]['requiredMessage'] = $required;
			if($this->formSended && $returnValue===''){
				$this->formContent[$id]['requiredError'] = true;
				$this->noErrors = false;
				$returnValue=false;
			} else {
				$this->formContent[$id]['requiredError'] = false;
			}
		}
		if($validate !== false){
			$this->formContent[$id]['validateErrorMessage'] = $validateErrorMessage;
			$this->formContent[$id]['validateError'] = false;
			if ($this->formSended && $returnValue!==false){
				if(!$this->{'validate'.$validate}($returnValue)){
					$this->formContent[$id]['validateError'] = true;
					$returnValue = false;
					$this->noErrors = false;
				}
			}
		}
		$this->formContent[$id]['tags'] = $tags;
		return $returnValue;
	}
	public function addFileInput($tagName, $tags=[], $maxFileSizeBytes=31457280, $isMultiple=true, $required=false, $saveFilesPath=false){
		$id = $this->setId();
		$this->formEnctype = 'multipart/form-data';
		$returnValue = null;
		$this->formContent[$id]['type']= 'file';
		$tagName = str_replace(['[', ']'], ['', ''], $tagName);
		$this->formContent[$id]['tagName']= $tagName;
		$this->formContent[$id]['maxFileSizeBytes']= $maxFileSizeBytes;
		$this->formContent[$id]['isMultiple']= $isMultiple;
		if($this->formSended && isset($_FILES[$tagName])){
			if(is_array($_FILES[$tagName]['name'])){
				if($_FILES[$tagName]['error'][0]===0){
					$returnValue = true;
				} else {
					$returnValue = false;
				}
			} else {
				if($_FILES[$tagName]['error']===0){
					$returnValue = true;
				} else {
					$returnValue = false;
				}
			}
		}
		if($required !== false){
			$this->formContent[$id]['requiredMessage'] = $required;
			if ($this->formSended && !$this->noErrors){
				$this->formContent[$id]['requiredMessage'] = 'Сначала корректно заполните<br>все обязательные поля!';
				$this->formContent[$id]['requiredError'] = true;
				$this->noErrors = false;
				$returnValue = false;
			} elseif($this->formSended && $returnValue === false){
				$this->formContent[$id]['requiredError'] = true;
				$returnValue = false;
				$this->noErrors = false;
			}
		}
		if($saveFilesPath!==false){
			if($returnValue){
				$uploaddir = $saveFilesPath;
				if(is_array($_FILES[$tagName]['name']) && $_FILES[$tagName]['error'][0]===0){
					$successSavedFilesCount = 0;
					$countFiles = count($_FILES[$tagName]['name'])-1;
					for($i=0;$i<=$countFiles;$i++){
						$uploadfile = $uploaddir . basename($_FILES[$tagName]['name'][$i]);
						if (move_uploaded_file($_FILES[$tagName]['tmp_name'][$i], $uploadfile)) {
							$successSavedFilesCount++;
						} else {
							$successSavedFilesCount--;
						}
					}
					if($countFiles+1 == $successSavedFilesCount){
						$returnValue = true;
					} else {
						$returnValue = false;
					}
				} elseif($_FILES[$tagName]['error']===0) {
					$uploadfile = $uploaddir . basename($_FILES[$tagName]['name']);
					if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
						$returnValue = true;
					} else {
						$returnValue = false;
					}
				} else {
					$returnValue = false;
				}
			}
		}
		$this->formContent[$id]['tags']= $tags;
		return $returnValue;
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
	private function saveSelectValues($id){
		if(isset($_REQUEST[$this->formContent[$id]['tagName']])){
			$result = $_REQUEST[$this->formContent[$id]['tagName']];
		} else {
			$result = false;
		}
		foreach($this->formContent[$id]['options'] as $key=>$optArr){
			if($optArr['type'] ==='selOptGr'){
				foreach($this->formContent[$id]['options'][$key]['options'] as $optKey=>$optArr2){
					if(is_array($result)){
						if(in_array($optArr2['value'], $result)){
							$this->formContent[$id]['options'][$key]['options'][$optKey]['tags']['selected']='';
						} else {
							unset($this->formContent[$id]['options'][$key]['options'][$optKey]['tags']['selected']);
						}
					} else {
						if($optArr2['value'] == $result){
							$this->formContent[$id]['options'][$key]['options'][$optKey]['tags']['selected']='';
						} else {
							unset($this->formContent[$id]['options'][$key]['options'][$optKey]['tags']['selected']);
						}
					}
				}
			} elseif($optArr['type'] ==='option'){
				if(is_array($result)){
					if(in_array($optArr['value'], $result)){
						$this->formContent[$id]['options'][$key]['tags']['selected']='';
					} else {
						unset($this->formContent[$id]['options'][$key]['tags']['selected']);
					}
				} else {
					if($optArr['value'] == $result){
						$this->formContent[$id]['options'][$key]['tags']['selected']='';
					} else {
						unset($this->formContent[$id]['options'][$key]['tags']['selected']);
					}
				}
			}
		}
	}
	//функции возврата HTML↓
	public function returnFileHtml($id){
		$opt = $this->formContent[$id];
		if($opt['isMultiple']){
			$opt['tagName'] = $opt['tagName'].'[]';
			$multiple = ' multiple ';
		} else {
			$multiple = '';
		}
		$tempStr = '<div class="formElement">';
		if(isset($opt['requiredError']) && $opt['requiredError']){
			$tempStr .= '<div class="requiredError">'.$opt['requiredMessage'].'</div>';
		}
		$tempStr .= '<input type="hidden" name="MAX_FILE_SIZE" value="'.$opt['maxFileSizeBytes'].'" '.$this->showFormIdOnEveryElement.'/>';
		$tempStr .= '<input name="'.$opt['tagName'].'" type="file" '.$multiple;
		$tempStr .= $this->tagsToHTML($opt['tags']).$this->showFormIdOnEveryElement;
		if(isset($opt['requiredMessage'])){$tempStr .= $this->requiredText;}
		$tempStr .= '>';
		$tempStr .= '</div>';
		return $tempStr;
	}
	public function formOpenHtml(){
		$tempStr = '<form action="'.$this->action.'" method="'.$this->method.'" enctype="'.$this->formEnctype.'"';
		$tempStr .= $this->tagsToHTML($this->tags);
		$tempStr .= ' id="'.$this->formId.'">';
		return $tempStr;
	}
	public function formCloseHtml(){
		$tempStr = '<input type="hidden" name="'.$this->formId.'" value="s">';
		$tempStr .= '</form>';
		return $tempStr;
	}
	public function returnTextareaHtml($id){
		$opt = $this->formContent[$id];
		$tempStr = '<div class="formElement">';
		if(isset($opt['requiredMessage']) && $opt['requiredError']){
			$tempStr .= '<div class="requiredError">'.$opt['requiredMessage'].'</div>';
		}
		if(isset($opt['validateErrorMessage']) && $opt['validateError']){
			$tempStr .= '<div class="validateError">'.$opt['validateErrorMessage'].'</div>';
		}
		$tempStr .= '<textarea name="'.$opt['tagName'].'" ';
		$tempStr .= $this->tagsToHTML($opt['tags']) .$this->showFormIdOnEveryElement;
		if(isset($opt['requiredMessage'])){$tempStr .= $this->requiredText;}
		$tempStr .= '>'.$opt['text'].'</textarea>';
		$tempStr .= '</div>';
		return $tempStr;
	}
	public function returnSelectGroupHtml($id){
		if(
			$this->formContent[$id]['saveFormValue'] === true && 
			$this->formSended && 
			$this->showValues
		){
			$this->saveSelectValues($id);
		}
		$opt = $this->formContent[$id];
		if($opt['isMultiple']){
			$multiple = 'multiple';
			$opt['tagName'] = $opt['tagName'].'[]';
		} else {
			$multiple = '';
		}
		$tempStr = '<div class="formElement"><div class="formSelect">';
		if(isset($opt['requiredError']) && $opt['requiredError']){
			$tempStr .= '<div class="requiredError">'.$opt['requiredMessage'].'</div>';
		}
		$tempStr .= '<select name="'.$opt['tagName'].'" '.$multiple.' '.$this->showFormIdOnEveryElement;
		if(isset($opt['requiredMessage'])){$tempStr .= $this->requiredText;}
		$tempStr .= $this->tagsToHTML($opt['tags']) . ' ';
		
		$tempStr .= '>';
		foreach($opt['options'] as $key=>$arrVal){
			if($arrVal['type'] == 'option'){
				$tempStr .= $this->returnSelectOptionHtml($arrVal);
			} elseif($arrVal['type'] == 'selOptGr'){
				$tempStr .= '<optgroup label="'.$arrVal['label'].'" '.$this->tagsToHTML($arrVal['tags']).' >';
				foreach($arrVal['options'] as $kkeyy=>$optArr2){
					$tempStr .= $this->returnSelectOptionHtml($optArr2);
				}
				$tempStr .= '</optgroup>';
			}
		}
		$tempStr .= '</select>';
		$tempStr .= '</div></div>';
		return $tempStr;
	}
	private function returnSelectOptionHtml($arrVal){
		$tempStr = '<option value="'.$arrVal['value'].'" '.$this->tagsToHTML($arrVal['tags']).' >'.$arrVal['text'].'</option>';
		return $tempStr;
	}
	public function returnButtonHtml($id){
		$tempStr = '<div class="formElement">';
		$tempStr .= '<button type="'.$this->formContent[$id]['btnType'].'" ';
		$tempStr .= $this->showFormIdOnEveryElement;
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
			$tempStr .= '<input type="radio" name="'.$opt['names'].'" value="'.$arrayValue['value'].'" '.$this->showFormIdOnEveryElement;
			$tempStr .= $this->tagsToHTML($arrayValue['tags']);
			if(isset($opt['requiredMessage'])){$tempStr .= $this->requiredText;}
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
		$tempStr .= '<input type="checkbox" name="'.$opt['tagName'].'" '.$this->showFormIdOnEveryElement;
		$tempStr .= $this->tagsToHTML($opt['tags']);
		if(isset($opt['requiredMessage'])){$tempStr .= $this->requiredText;}
		$tempStr .= '></div>';
		return $tempStr;
	}
	public function returnTextInputHtml($id, $type='text'){
		$opt = $this->formContent[$id];
		$tempStr = '<div class="formElement">';
		if(isset($opt['requiredError']) && $opt['requiredError']){
			$tempStr .= '<div class="requiredError">'.$opt['requiredMessage'].'</div>';
		}
		if(isset($opt['validateError']) && $opt['validateError']){
			$tempStr .= '<div class="validateError">'.$opt['validateMessage'].'</div>';
		}
		if($type !== 'password' && $type !== 'text' && $type !== 'email'){
			$type = 'text';
		}
		$tempStr .= '<input type="'.$type.'" name="'.$opt['tagName'].'" '.$this->showFormIdOnEveryElement;
		$tempStr .= $this->tagsToHTML($opt['tags']);
		if(isset($opt['requiredMessage'])){$tempStr .= $this->requiredText;}
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
			case 'select':
				$tempStr .= $this->returnSelectGroupHtml($id);
				break;
			case 'textarea':
				$tempStr .= $this->returnTextareaHtml($id);
				break;
			case 'file':
				$tempStr .= $this->returnFileHtml($id);
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
$inputForm->labelOpen('', ['class'=>'remCheckbox']);
$tt = $inputForm->addCheckBox('remember', [ 'value'=>'23'], true, 'Поставь галочку');
$inputForm->labelClose('<span>Я согласен с правилами портала</span>');
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
$inputForm->requiredText = '';







if($inputForm->noErrors && $inputForm->formSended){
	//$inputForm->clearAllValues();
} 


$loginForm = $inputForm->returnFullHtml();
//var_dump($pass, $pass2);
var_dump($file1);
//var_dump($inputForm->formContent[$file1Id]);

//echo Inputform::tagsToHTML(['hey'=>'Привет']) . '<br>';
//var_dump($_FILES);
//var_dump($_REQUEST);
echo '</pre>';
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
			<filelist>
			<!--<keygen keytype="rsa" form="login123" name="security">
			<button type="submit" form="login123" >отправить</button>
			<meter value=".8" low=".25" high=".75" optimum=".2"></meter>
			<progress value="0.75">Выполнено 75% работы</progress>
			-->
	</body>
</html>
