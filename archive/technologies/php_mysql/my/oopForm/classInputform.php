<?php
class InputForm 
{
	private $formId = '';
	public $formSended = false;
	private $action = '';
	private $method = '';
	private $formEnctype = 'application/x-www-form-urlencoded';
	private $tags = [];
	private $showFormIdOnEveryElement = '';
	public $functionAddToUserValues = false;
	public $id = 0;
	public $requiredText = ' required ';
	public $validateCustomFunction;
	public $formContent = [];
	public $validateLoginRegEx = 
		'#(?!(?:^\d*$)|.{31})^[a-z0-9]{1}(?:[a-z0-9]|(?:[-](?!(?:-)|(?:_)))|(?:[_](?!(?:-)|(?:_))))+[a-z0-9]{1}$#i';
	public $validatePasswordRegEx = '#^[^а-я]{6,30}$#iu';
	public $validateCustomRegEx = '#^.{10,30}$#iu';
	public $noErrors = true;
	private $showValues = true;
	
	function __construct(
		$action = '.', 
		$method = 'GET', 
		$tags = [], 
		$formId ='form', 
		$enctype = 'application/x-www-form-urlencoded'
	) {
		$this->action = $action;
		$this->method = $method;
		$this->formEnctype = $enctype;
		$tagsArr = [];
		$this->tags = $tags;
		$this->formId = $formId;
		if (
			isset($_REQUEST[$formId]) && 
			's' === $_REQUEST[$formId]
		) {
			$this->formSended = true;
		}
	}
	
	public function showFormIdOnEveryElement($show = false)
	{
		$this->showFormIdOnEveryElement = (true === $show) ? ' form="' . $this->formId . '" ' : '';
	}
	
	private function setId()
	{
		$this->id++;
		return $this->id;
	}
	
	public function validateCustom($str)
	{
		return 1 === preg_match($this->validateCustomRegEx, $str);
	}
	
	public function validateLogin($str)
	{
		return 1 === preg_match($this->validateLoginRegEx, $str);
	}
	
	public function validatePassword($str)
	{
		return 1 === preg_match($this->validatePasswordRegEx, $str);
	}
	
	public function validateEmail($str)
	{
		return filter_var($str, FILTER_VALIDATE_EMAIL);
	}
	
	public function validateCustomFunction($str)
	{
		return $this->validateCustomFunction->__invoke($str);
	}
	
	public function clearAllValues()
	{
		$this->showValues = false;
		foreach ($this->formContent as $id => $optionsArray) {
			$type = $optionsArray['type'];
			if (
				$type === 'text' || 
				$type === 'password' || 
				$type === 'email'
			) {
				unset($this->formContent[$id]['tags']['value']);
			} elseif ($type === 'checkbox') {
				unset($this->formContent[$id]['tags']['checked']);
			} elseif ($type === 'radioGroup') {
				foreach ($optionsArray['buttons'] as $key => $arr) {
					unset($this->formContent[$id]['buttons'][$key]['tags']['checked']);
				}
			} elseif ($type === 'select') {
				foreach ($optionsArray['options'] as $selKey => $selOpt) {
					if ($selOpt['type'] == 'selOptGr') {
						foreach ($selOpt['options'] as $selKey2 => $selOpt2) {
							unset($this->formContent[$id]['options'][$selKey]['options'][$selKey2]['tags']['selected']);
						}
					} elseif ($selOpt['type'] == 'option') {
						unset($this->formContent[$id]['options'][$selKey]['tags']['selected']);
					}
				}
			}
		}
	}
	
	static function tagsToHTML($tags = [])
	{
		$result = '';
		foreach ($tags as $tag => $val) {
			$result .= ' ' . $tag . '="' . $val . '" ';
		}
		return $result;
	}
	
	public function addHtml($HTML = '')
	{
		$id = $this->setId();
		$this->formContent[$id]['type'] = 'pureHtml';
		$this->formContent[$id]['content'] = $HTML;
	}
	
	public function labelOpen ($HTMLcontent = '', $tags = [])
	{
		$id = $this->setId();
		$this->formContent[$id]['type'] = 'labelOpen';
		$this->formContent[$id]['tags'] = $tags;
		$this->formContent[$id]['HTMLcontent'] = $HTMLcontent;
	}
	
	public function labelClose($HTMLcontentBeforeClose = '')
	{
		$id = $this->setId();
		$this->formContent[$id]['type'] = 'labelClose';
		$this->formContent[$id]['HTMLcontentBeforeClose'] = $HTMLcontentBeforeClose;
	}
	
	//функции создания элементов формы↓
	public function addTextInput(
		$tagName, 
		$saveFormValue = false, 
		$tags = [], 
		$required = false, 
		$validate = false, 
		$validateErrorMessage = 'Поле заполнено неверно', 
		$type = 'text'
	) {
		$id = $this->setId();
		if ($type !== 'password' && $type !== 'text' && $type !== 'email') {
			$type = 'text';
		}
		$this->formContent[$id]['type'] = $type;
		$this->formContent[$id]['tagName'] = $tagName;
		$returnValue = false;
		if ($this->formSended && isset($_REQUEST[$tagName])) {
			if (is_callable($this->functionAddToUserValues)) {
				$returnValue = $this->functionAddToUserValues->__invoke($_REQUEST[$tagName]);
			} else {
				$returnValue = $_REQUEST[$tagName];
			}
		}
		if ($saveFormValue && $returnValue !== false) {
			$tags['value'] = $returnValue;
		}
		if ($required !== false) {
			$this->formContent[$id]['requiredMessage'] = $required;
			if  ($this->formSended && $returnValue === ''){
				$this->formContent[$id]['requiredError'] = true;
				$returnValue = false;
				$this->noErrors = false;
			} else {
				$this->formContent[$id]['requiredError'] = false;
			}
		}
		if ($validate !== false) {
			$this->formContent[$id]['validateMessage'] = $validateErrorMessage;
			$this->formContent[$id]['validateError'] = false;
			if ($returnValue !== false && $returnValue!=='') {
				if (!$this->{'validate'.$validate}($returnValue)) {
					$this->formContent[$id]['validateError'] = true;
					$returnValue = false;
					$this->noErrors = false;
				}
			}
		}
		$this->formContent[$id]['tags'] = $tags;
		if ($type === 'password' || $type === 'email') {
			$returnValue = ['id'=>$id, 'value'=>$returnValue];
		}
		return $returnValue;
	}
	
	public function addPasswordInput(
		$tagName, 
		$saveFormValue = false, 
		$tags = [], 
		$required = false, 
		$validate = false, 
		$validateErrorMessage = 'Поле заполнено неверно', 
		$passNeedСonfirm = false, 
		$passConfirmMesssage = 'Пароли не совпадают!'
	) {
		$retArr = $this->addTextInput(
			$tagName, 
			$saveFormValue, 
			$tags, 
			$required, 
			$validate,
			$validateErrorMessage, 
			'password'
		);
		$id = $retArr['id'];
		$pass = $retArr['value'];
		if ($passNeedСonfirm !== false) {
			$confirmPassId = $passNeedСonfirm;
			$confirmPassTagName = $this->formContent[$confirmPassId]['tagName'];
			$notEntered = (
				$this->formContent[$id]['requiredError'] || 
				$this->formContent[$confirmPassId]['requiredError']
			);
			//$notValidated = $this->formContent[$name]['validateError'] || $this->formContent[$passNeedСonfirm]['validateError'];
			if (!$notEntered && $this->formSended) {
				if ($_REQUEST[$confirmPassTagName] != $_REQUEST[$tagName]) {
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
	
	public function addCheckBox(
		$tagName, 
		$tags=[], 
		$saveFormValue = false, 
		$required = false, 
		$htmlBefore='', 
		$htmlAfter=''
	) {
		$id = $this->setId();
		$this->formContent[$id]['tagName'] = $tagName;
		$this->formContent[$id]['type'] = 'checkbox';
		$this->formContent[$id]['htmlBefore'] = $htmlBefore;
		$this->formContent[$id]['htmlAfter'] = $htmlAfter;
		$returnValue = false;
		if ($this->formSended) {
			if (isset($_REQUEST[$tagName])) {
				$returnValue = $_REQUEST[$tagName];
			} else {
				$returnValue = false;
			}
		}
		if ($saveFormValue !== false) {
			if ($returnValue !== false) {
				$tags['checked'] = '';
			} elseif ($this->formSended) {
				unset($tags['checked']);
			}
		}
		if ($required !== false) {
			$this->formContent[$id]['requiredMessage'] = $required;
			$this->formContent[$id]['requiredError'] = false;
			if ($this->formSended && $returnValue === false) {
				$this->formContent[$id]['requiredError'] = true;
				$this->noErrors = false;
			}
		}
		$this->formContent[$id]['tags'] = $tags;
		return $returnValue;
	}
	
	public function addRadioButtonGroup(
		$radioNames, 
		$saveFormValue = true, 
		$required = true
	) {
		$id = $this->setId();
		$this->formContent[$id]['type'] = 'radioGroup';
		$this->formContent[$id]['names'] = $radioNames;
		$this->formContent[$id]['buttons'] = [];
		$this->formContent[$id]['saveFormValue'] = $saveFormValue;
		$returnValue = false;
		if ($this->formSended) {
			if (isset($_REQUEST[$radioNames])) {
				$returnValue = $_REQUEST[$radioNames];
			} else {
				$returnValue = false;
			}
		}
		if ($required) {
			$this->formContent[$id]['requiredMessage'] = $required;
			$this->formContent[$id]['requiredError'] = false;
			if ($this->formSended && $returnValue === false) {
				$this->formContent[$id]['requiredError'] = true;
				$this->noErrors = false;
			}
		}
		$this->formContent[$id]['returnValue'] = $returnValue;
		return $returnValue;
	}
	
	public function addButton(
		$btnType, 
		$HTMLcontent, 
		$tags = []
	){
		$id = $this->setId();
		$this->formContent[$id]['type'] = 'button';
		$this->formContent[$id]['btnType'] = $btnType;
		$this->formContent[$id]['HTMLcontent'] = $HTMLcontent;
		$this->formContent[$id]['tags'] = $tags;
		if (isset($tags['name']) && isset($tags['value'])) {
			if (
				$this->formSended && 
				isset($_REQUEST[$tags['name']]) && 
				$_REQUEST[$tags['name']] == $tags['value']
			) {
				return $_REQUEST[$tags['name']];
			}
		}
	}
	
	public function addRadioToGroup(
		$groupId, 
		$value, 
		$htmlBefore = '', 
		$htmlAfter = '', 
		$tags = []
	) {
		$id = $this->setId();
		$this->formContent[$groupId]['buttons'][$id]['value'] = $value;
		$this->formContent[$groupId]['buttons'][$id]['htmlBefore'] = $htmlBefore;
		$this->formContent[$groupId]['buttons'][$id]['htmlAfter'] = $htmlAfter;
		$this->formContent[$groupId]['buttons'][$id]['tags'] = $tags;
	}
	
	public function addEmailInput(
		$tagName, 
		$saveFormValue = false, 
		$tags = [], 
		$required = false, 
		$validate = false, 
		$validateErrorMessage = 'Не корректный E-mail!'
	) {
		$retArr = $this->addTextInput(
			$tagName, 
			$saveFormValue, 
			$tags, 
			$required, 
			$validate, 
			$validateErrorMessage, 
			$type='email'
		);
		$id = $retArr['id'];
		$email = $retArr['value'];
		return $email;
	}
	
	public function addSelect (
		$tagName, 
		$isMultiple = true, 
		$saveFormValue = false, 
		$tags = [], 
		$required = false
	) {
		$id = $this->setId();
		$this->formContent[$id]['type'] = 'select';
		$tagName = str_replace(['[', ']'], ['', ''], $tagName);
		$this->formContent[$id]['tagName'] = $tagName;
		$this->formContent[$id]['isMultiple'] = $isMultiple;
		$this->formContent[$id]['saveFormValue'] = $saveFormValue;
		$this->formContent[$id]['tags'] = $tags;
		$returnValue = false;
		if (
			$this->formSended && 
			isset($_REQUEST[$tagName]) && 
			!empty($_REQUEST[$tagName])
		) {
			$returnValue = $_REQUEST[$tagName];
		}
		if ($required !== false) {
			$this->formContent[$id]['requiredMessage'] = $required;
			if ($this->formSended && $returnValue === false) {
				$this->formContent[$id]['requiredError'] = true;
				$this->noErrors = false;
			}
		}
		$this->formContent[$id]['options'] = [];
		return $returnValue;
	}
	
	public function addOptGroupToSelect(
		$selectId, 
		$label, 
		$tags = []
	) {
		$id = $this->setId();
		$this->formContent[$selectId]['options'][$id]['type'] = 'selOptGr';
		$this->formContent[$selectId]['options'][$id]['label'] = $label;
		$this->formContent[$selectId]['options'][$id]['tags'] = $tags;
		$this->formContent[$selectId]['options'][$id]['options'] = [];
	}
	
	public function addOptionToSelect(
		$selectId, 
		$text, 
		$value, 
		$tags = [], 
		$addToOptGroupId = false
	) {
		$id = $this->setId();
		$parent =& $this->formContent[$selectId]['options'];
		if ($addToOptGroupId !== false) {
			$parent =& $this->formContent[$selectId]['options'][$addToOptGroupId]['options'];
		}
		$parent[$id]['type'] = 'option';
		$parent[$id]['text'] = $text;
		$parent[$id]['value'] = $value;
		$parent[$id]['tags'] = $tags;
	}
	
	public function addTextArea(
		$tagName, 
		$tags = [],
		$text = '', 
		$saveFormValue = false, 
		$required = false, 
		$validate = false, 
		$validateErrorMessage = 'Неверные данные!'
	) {
		$id = $this->setId();
		$returnValue = false;
		$this->formContent[$id]['type']= 'textarea';
		$this->formContent[$id]['tagName']= $tagName;
		$this->formContent[$id]['text']= $text;
		if ($this->formSended && isset($_REQUEST[$tagName])) {
			if (is_callable($this->functionAddToUserValues)) {
				$returnValue = $this->functionAddToUserValues->__invoke($_REQUEST[$tagName]);
			} else {
				$returnValue = $_REQUEST[$tagName];
			}
		}
		if ($saveFormValue !== false && $returnValue !== false) {
			$this->formContent[$id]['text'] = $returnValue;
		}
		if ($required !== false) {
			$this->formContent[$id]['requiredMessage'] = $required;
			if ($this->formSended && $returnValue === '') {
				$this->formContent[$id]['requiredError'] = true;
				$this->noErrors = false;
				$returnValue = false;
			} else {
				$this->formContent[$id]['requiredError'] = false;
			}
		}
		if ($validate !== false) {
			$this->formContent[$id]['validateErrorMessage'] = $validateErrorMessage;
			$this->formContent[$id]['validateError'] = false;
			if ($this->formSended && $returnValue !== false) {
				if (!$this->{'validate'.$validate}($returnValue)) {
					$this->formContent[$id]['validateError'] = true;
					$returnValue = false;
					$this->noErrors = false;
				}
			}
		}
		
		$this->formContent[$id]['tags'] = $tags;
		return $returnValue;
	}
	
	public function addFileInput(
		$tagName, 
		$tags = [], 
		$maxFileSizeBytes = 31457280, 
		$isMultiple = true, 
		$required = false, 
		$saveFilesPath = false
	) {
		$id = $this->setId();
		$this->formEnctype = 'multipart/form-data';
		$returnValue = false;
		$this->formContent[$id]['type']= 'file';
		$tagName = str_replace(['[', ']'], ['', ''], $tagName);
		$this->formContent[$id]['tagName']= $tagName;
		$this->formContent[$id]['maxFileSizeBytes']= $maxFileSizeBytes;
		$this->formContent[$id]['isMultiple']= $isMultiple;
		if ($this->formSended && isset($_FILES[$tagName])) {
			if (is_array($_FILES[$tagName]['name'])) {
				if ($_FILES[$tagName]['error'][0] === 0) {
					$returnValue = true;
				} else {
					$returnValue = false;
				}
			} else {
				if ($_FILES[$tagName]['error'] === 0){
					$returnValue = true;
				} else {
					$returnValue = false;
				}
			}
		}
		if ($required !== false) {
			$this->formContent[$id]['requiredMessage'] = $required;
			if ($this->formSended && !$this->noErrors) {
				$this->formContent[$id]['requiredMessage'] = 'Сначала корректно заполните<br>все обязательные поля!';
				$this->formContent[$id]['requiredError'] = true;
				$this->noErrors = false;
				$returnValue = false;
			} elseif ($this->formSended && $returnValue === false) {
				$this->formContent[$id]['requiredError'] = true;
				$returnValue = false;
				$this->noErrors = false;
			}
		}
		if ($saveFilesPath !== false) {
			if ($returnValue) {
				$uploaddir = $saveFilesPath;
				if (!is_dir($uploaddir)) {
					mkdir($uploaddir, 0777, true);
				}
				if (
					is_array($_FILES[$tagName]['name']) && 
					$_FILES[$tagName]['error'][0] === 0
				) {
					$filesNames = [];
					$successSavedFilesCount = 0;
					$countFiles = count($_FILES[$tagName]['name'])-1;
					for ($i=0;$i<=$countFiles;$i++) {
						$uploadfile = $uploaddir . basename($_FILES[$tagName]['name'][$i]);
						if (move_uploaded_file($_FILES[$tagName]['tmp_name'][$i], $uploadfile)) {
							$filesNames[] = basename($_FILES[$tagName]['name'][$i]);
							$successSavedFilesCount++;
						} else {
							$successSavedFilesCount--;
						}
					}
					if ($countFiles+1 == $successSavedFilesCount) {
						$returnValue = $filesNames;
					} else {
						$returnValue = false;
					}
				} elseif ($_FILES[$tagName]['error']===0) {
					$fileName = '';
					$uploadfile = $uploaddir . basename($_FILES[$tagName]['name']);
					if (move_uploaded_file($_FILES[$tagName]['tmp_name'], $uploadfile)) {
						$returnValue = basename($_FILES[$tagName]['name']);
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
	
	//функции создания элементов формы↑
	private function saveValuesRadioGroup($id)
	{
		foreach ($this->formContent[$id]['buttons'] as $key=>$button) {
			if ($this->formContent[$id]['returnValue'] == $button['value']) {
				$this->formContent[$id]['buttons'][$key]['tags']['checked'] = '';
			} else {
				unset($this->formContent[$id]['buttons'][$key]['tags']['checked']);
			}
		}
	}
	
	private function saveSelectValues($id)
	{
		if (isset($_REQUEST[$this->formContent[$id]['tagName']])) {
			$result = $_REQUEST[$this->formContent[$id]['tagName']];
		} else {
			$result = false;
		}
		foreach ($this->formContent[$id]['options'] as $key=>$optArr) {
			if ($optArr['type'] ==='selOptGr') {
				foreach ($this->formContent[$id]['options'][$key]['options'] as $optKey=>$optArr2) {
					if (is_array($result)) {
						if (in_array($optArr2['value'], $result)) {
							$this->formContent[$id]['options'][$key]['options'][$optKey]['tags']['selected'] = '';
						} else {
							unset($this->formContent[$id]['options'][$key]['options'][$optKey]['tags']['selected']);
						}
					} else {
						if ($optArr2['value'] == $result) {
							$this->formContent[$id]['options'][$key]['options'][$optKey]['tags']['selected'] = '';
						} else {
							unset($this->formContent[$id]['options'][$key]['options'][$optKey]['tags']['selected']);
						}
					}
				}
			} elseif ($optArr['type'] ==='option') {
				if (is_array($result)) {
					if (in_array($optArr['value'], $result)) {
						$this->formContent[$id]['options'][$key]['tags']['selected']='';
					} else {
						unset($this->formContent[$id]['options'][$key]['tags']['selected']);
					}
				} else {
					if ($optArr['value'] == $result) {
						$this->formContent[$id]['options'][$key]['tags']['selected']='';
					} else {
						unset($this->formContent[$id]['options'][$key]['tags']['selected']);
					}
				}
			}
		}
	}
	
	//функции возврата HTML↓
	public function returnFileHtml($id)
	{
		$opt = $this->formContent[$id];
		if ($opt['isMultiple']) {
			$opt['tagName'] = $opt['tagName'].'[]';
			$multiple = ' multiple ';
		} else {
			$multiple = '';
		}
		$tempStr = '<div class="formElement">';
		if (isset($opt['requiredError']) && $opt['requiredError']) {
			$tempStr .= '<div class="requiredError">' . $opt['requiredMessage'] . '</div>';
		}
		$tempStr .= 	'<input type="hidden" name="MAX_FILE_SIZE" value="' .
						$opt['maxFileSizeBytes'] .
						'" ' .
						$this->showFormIdOnEveryElement .
						'/>';
		
		$tempStr .= 	'<input name="' .
						$opt['tagName'] .
						'" type="file" ' .
						$multiple;
		
		$tempStr .= $this->tagsToHTML($opt['tags']) . $this->showFormIdOnEveryElement;
		if (isset($opt['requiredMessage'])) {
			$tempStr .= $this->requiredText;
		}
		$tempStr .= '>';
		$tempStr .= '</div>';
		return $tempStr;
	}
	public function formOpenHtml()
	{
		$tempStr = 	'<form action="' . 
					$this->action . 
					'" method="' . 
					$this->method . 
					'" enctype="' .
					$this->formEnctype .
					'"';
					
		$tempStr .= $this->tagsToHTML($this->tags);
		$tempStr .= ' id="'.$this->formId.'">';
		return $tempStr;
	}
	
	public function formCloseHtml()
	{
		$tempStr = '<input type="hidden" name="' . $this->formId . '" value="s">';
		$tempStr .= '</form>';
		return $tempStr;
	}
	
	public function returnTextareaHtml($id)
	{
		$opt = $this->formContent[$id];
		$tempStr = '<div class="formElement">';
		if (isset($opt['requiredMessage']) && $opt['requiredError']) {
			$tempStr .= '<div class="requiredError">' . $opt['requiredMessage'] . '</div>';
		}
		if (isset($opt['validateErrorMessage']) && $opt['validateError']) {
			$tempStr .= '<div class="validateError">' . $opt['validateErrorMessage'] . '</div>';
		}
		$tempStr .= '<textarea name="' . $opt['tagName'] . '" ';
		$tempStr .= $this->tagsToHTML($opt['tags']) . $this->showFormIdOnEveryElement;
		if (isset($opt['requiredMessage'])) {
			$tempStr .= $this->requiredText;
		}
		$tempStr .= '>' . $opt['text'] . '</textarea>';
		$tempStr .= '</div>';
		return $tempStr;
	}
	
	public function returnSelectGroupHtml($id)
	{
		if(
			$this->formContent[$id]['saveFormValue'] === true && 
			$this->formSended && 
			$this->showValues
		) {
			$this->saveSelectValues($id);
		}
		$opt = $this->formContent[$id];
		if ($opt['isMultiple']) {
			$multiple = 'multiple';
			$opt['tagName'] = $opt['tagName'] . '[]';
		} else {
			$multiple = '';
		}
		$tempStr = '<div class="formElement"><div class="formSelect">';
		if (isset($opt['requiredError']) && $opt['requiredError']) {
			$tempStr .= '<div class="requiredError">' . $opt['requiredMessage'] . '</div>';
		}
		$tempStr .= 	'<select name="' .
						$opt['tagName'] . 
						'" ' . 
						$multiple . 
						' ' . 
						$this->showFormIdOnEveryElement;
						
		if (isset($opt['requiredMessage'])) {
			$tempStr .= $this->requiredText;
		}
		$tempStr .= $this->tagsToHTML($opt['tags']) . ' ';
		
		$tempStr .= '>';
		foreach ($opt['options'] as $key=>$arrVal) {
			if ($arrVal['type'] == 'option') {
				$tempStr .= $this->returnSelectOptionHtml($arrVal);
			} elseif ($arrVal['type'] == 'selOptGr') {
				$tempStr .= 	'<optgroup label="' .
								$arrVal['label'] .
								'" ' .
								$this->tagsToHTML($arrVal['tags']) .
								' >';
								
				foreach ($arrVal['options'] as $kkeyy=>$optArr2) {
					$tempStr .= $this->returnSelectOptionHtml($optArr2);
				}
				$tempStr .= '</optgroup>';
			}
		}
		$tempStr .= '</select>';
		$tempStr .= '</div></div>';
		return $tempStr;
	}
	
	private function returnSelectOptionHtml($arrVal)
	{
		$tempStr = 	'<option value="' .
					$arrVal['value'] . 
					'" ' .
					$this->tagsToHTML($arrVal['tags']) .
					' >' .
					$arrVal['text'] .
					'</option>';
		return $tempStr;
	}
	
	public function returnButtonHtml($id)
	{
		$tempStr = '<div class="formElement">';
		$tempStr .= '<button type="' . $this->formContent[$id]['btnType'] . '" ';
		$tempStr .= $this->showFormIdOnEveryElement;
		$tempStr .= $this->tagsToHTML($this->formContent[$id]['tags']);
		$tempStr .= '>';
		$tempStr .= $this->formContent[$id]['HTMLcontent'];
		$tempStr .= '</button></div>';
		return $tempStr;
	}
	
	public function returnRadioGroupHtml($id)
	{
		if (
			$this->formContent[$id]['saveFormValue'] === true && 
			$this->formSended && 
			$this->formContent[$id]['returnValue'] !== false && 
			$this->showValues
		) {
			$this->saveValuesRadioGroup($id);
		}
		$opt = $this->formContent[$id];
		$tempStr = '<div class="formElement"><div class="radioButtonsGroup">';
		if (isset($opt['requiredError']) && $opt['requiredError']) {
			$tempStr .= '<div class="requiredError">' . $opt['requiredMessage'] . '</div>';
		}
		foreach ($opt['buttons'] as $key=>$arrayValue) {
			$tempStr .= $arrayValue['htmlBefore'];
			$tempStr .= 	'<input type="radio" name="' .
							$opt['names'] .
							'" value="' .
							$arrayValue['value'] .
							'" ' .
							$this->showFormIdOnEveryElement;
							
			$tempStr .= $this->tagsToHTML($arrayValue['tags']);
			if (isset($opt['requiredMessage'])) {
				$tempStr .= $this->requiredText;
			}
			$tempStr .= '>';
			$tempStr .= $arrayValue['htmlAfter'];
		}
		$tempStr .= '</div></div>';
		return $tempStr;
	}
	
	public function returnCheckBoxHtml($id)
	{
		$opt = $this->formContent[$id];
		$tempStr = '<div class="formElement">';
		if (isset($opt['requiredError']) && $opt['requiredError']) {
			$tempStr .= '<div class="requiredError">' . $opt['requiredMessage'] . '</div>';
		}
		$tempStr .= $opt['htmlBefore'];
		$tempStr .=	'<input type="checkbox" name="' .
					$opt['tagName'] .
					'" ' .
					$this->showFormIdOnEveryElement;
					
		$tempStr .= $this->tagsToHTML($opt['tags']);
		if (isset($opt['requiredMessage'])) {
			$tempStr .= $this->requiredText;
		}
		$tempStr .= '>';
		$tempStr .= $opt['htmlAfter'];
		$tempStr .= '</div>';
		return $tempStr;
	}
	
	public function returnTextInputHtml($id, $type = 'text')
	{
		$opt = $this->formContent[$id];
		$tempStr = '<div class="formElement">';
		if (isset($opt['requiredError']) && $opt['requiredError']) {
			$tempStr .= '<div class="requiredError">' . $opt['requiredMessage'] . '</div>';
		}
		if (isset($opt['validateError']) && $opt['validateError']) {
			$tempStr .= '<div class="validateError">' . $opt['validateMessage'] . '</div>';
		}
		if($type !== 'password' && $type !== 'text' && $type !== 'email'){
			$type = 'text';
		}
		$tempStr .=	'<input type="' .
					$type .
					'" name="' .
					$opt['tagName'] .
					'" ' .
					$this->showFormIdOnEveryElement;
					
		$tempStr .= $this->tagsToHTML($opt['tags']);
		if (isset($opt['requiredMessage']))	$tempStr .= $this->requiredText;
		$tempStr .= '></div>';
		return $tempStr;
	}
	
	public function returnPasswordInputHtml($id)
	{
		$tempStr = $this->returnTextInputHtml($id, 'password');
		return $tempStr;
	}
	
	public function returnEmailInputHtml($id)
	{
		$tempStr = $this->returnTextInputHtml($id, 'email');
		return $tempStr;
	}
	
	public function labelOpenHtml($id)
	{
		$tempStr = '<label ';
		$tempStr .= $this->tagsToHTML($this->formContent[$id]['tags']);
		$tempStr .= '>' . $this->formContent[$id]['HTMLcontent'];
		return $tempStr;
	}
	
	public function labelCloseHtml($id)
	{
		$tempStr ='' . $this->formContent[$id]['HTMLcontentBeforeClose'] . '</label>';
		return $tempStr;
	}
	
	public function returnHtmlbyId($id)
	{
		$tempStr = '';
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
				$tempStr .= ' ' . $this->formContent[$id]['content'] . ' ';
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
	
	public function returnHtmlBeetweenIDs($BeginId, $EndId)
	{
		$tempStr = '';
		for ($i = $BeginId; $i <= $EndId; $i++) {
			if (isset($this->formContent[$i])) {
				$tempStr .= $this->returnHtmlbyId($i);
			}
		}
		return $tempStr;
	}
	
	public function returnFullHtml()
	{
		$returnHtml = $this->formOpenHtml();
		foreach ($this->formContent as $id=>$inpArr) {
			$returnHtml .= $this->returnHtmlbyId($id);
		}
		$returnHtml .= $this->formCloseHtml();
		return $returnHtml;
	}
	//функции возврата HTML↑
}
