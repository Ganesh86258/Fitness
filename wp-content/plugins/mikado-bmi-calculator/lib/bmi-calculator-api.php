<?php
namespace MikadoBmiCalculator\Lib;

/**
 * Class BmiCalculatorApi
 * @package MikadoBmiCalculator\Lib
 */
class BmiCalculatorApi {
	/**
	 * @var
	 */
	private static $instance;

	/**
	 * @var
	 */
	private $height;
	/**
	 * @var
	 */
	private $weight;
	/**
	 * @var
	 */
	private $age;
	/**
	 * @var
	 */
	private $sex;
	/**
	 * @var
	 */
	private $activityLevel;
	/**
	 * @var
	 */
	private $allowedActivityLevels;

	private $labels;

	/**
	 * Private constuct because of Singletone
	 */
	private function __construct() {
		$this->setAllowedFitnessLevels();
		$this->setLabels();
		add_action('wp_ajax_mkd_bmi_calculate', array($this, 'handleForm'));
		add_action('wp_ajax_nopriv_mkd_bmi_calculate', array($this, 'handleForm'));
	}

	/**
	 * Private sleep because of Singletone
	 */
	private function __wakeup() {
	}

	/**
	 * Private clone because of Singletone
	 */
	private function __clone() {
	}

	/**
	 * Returns current instance of class
	 * @return ShortcodeLoader
	 */
	public static function getInstance() {
		if(self::$instance == null) {
			return new self;
		}

		return self::$instance;
	}

	/**
	 *
	 */
	public function handleForm() {
		$responseObj = new \stdClass();

		if(!empty($_POST['formData'])) {
			$this->parsePostData($_POST['formData']);

			$validation = $this->validatePostData();

			$responseObj->hasError = $validation->hasError;

			if(!$responseObj->hasError) {
				$responseObj->BMI     = $this->calculateBMI();
				$responseObj->BMIRank = $this->getBMIRank($responseObj->BMI);
				$responseObj->BMR     = $this->calculateBMR($this->sex, $this->weight, $this->height, $this->age);
				$responseObj->TDEE    = $this->calculateTDEE($responseObj->BMR, $this->activityLevel);

				$responseObj->notificationText = $this->generateNotificationText(round($responseObj->BMI, 2), $responseObj->BMR, $responseObj->TDEE);
			} else {
				$responseObj->notificationText = $validation->messages;
			}
		} else {
			$responseObj->hasError = true;
		}

		echo json_encode($responseObj);
		exit;
	}

	/**
	 *
	 */
	private function setAllowedFitnessLevels() {
		$this->allowedActivityLevels = array(
			'little',
			'light',
			'moderate',
			'heavy',
			'very_heavy'
		);
	}

	/**
	 * @param $activityLevel
	 *
	 * @return bool
	 */
	private function validActivityLevel($activityLevel) {
		return in_array($activityLevel, $this->allowedActivityLevels);
	}

	/**
	 * @param $data
	 *
	 * @return bool
	 */
	public function parsePostData($data) {
		parse_str($data, $dataArray);

		if(is_array($dataArray) && count($dataArray)) {
			if(!empty($dataArray['height']) && is_numeric($dataArray['height']) && $dataArray['height'] > 0) {
				$this->height = floatval($dataArray['height']);
			}

			if(!empty($dataArray['weight']) && is_numeric($dataArray['weight']) && $dataArray['weight'] > 0) {
				$this->weight = floatval($dataArray['weight']);
			}

			if(!empty($dataArray['sex'])) {
				$this->sex = $dataArray['sex'];
			}

			if(!empty($dataArray['age']) && is_numeric($dataArray['age'])) {
				$this->age = (int) $dataArray['age'];
			}

			if(!empty($dataArray['activity_level']) && $this->validActivityLevel($dataArray['activity_level'])) {
				$this->activityLevel = $dataArray['activity_level'];
			}

			return true;
		}

		return false;
	}

	/**
	 * @return \stdClass
	 */
	private function validatePostData() {
		$validationObject = new \stdClass();

		$validationObject->hasError = false;
		$validationObject->messages = array();

		if(empty($this->height) && !is_numeric($this->height)) {
			$validationObject->hasError   = true;
			$validationObject->messages[] = esc_html__('Please provide a valid height', 'mkd_bmi');
		}

		if(empty($this->weight) && !is_numeric($this->weight)) {
			$validationObject->hasError   = true;
			$validationObject->messages[] = esc_html__('Please provide a valid weight', 'mkd_bmi');
		}

		if(!empty($this->age) && !(is_int($this->age) && $this->age > 0)) {
			$validationObject->hasError   = true;
			$validationObject->messages[] = esc_html__('Please provide a valid age', 'mkd_bmi');
		}

		$validationObject->messages = implode('. ', $validationObject->messages);

		return $validationObject;
	}

	private function calculateBMI() {
		$bmi = $this->weight / pow(($this->height / 100), 2);

		return $bmi;
	}

	private function calculateBMR($sex, $weight, $height, $age) {
		$BMR = 0;

		if(!empty($sex) && in_array($sex, array('male', 'female'))
		   && !empty($age) && is_int($age)
		) {
			switch($sex) {
				case 'male':
					$BMR = 10 * $weight + 6.25 * $height - 5 * $age + 5;
					break;
				case 'female':
					$BMR = 10 * $weight + 6.25 * $height - 5 * $age - 161;
					break;
			}
		}

		return $BMR;
	}

	private function calculateTDEE($BMR, $activityLevel) {
		$TDEE = 0;
		if(!empty($BMR) && $this->validActivityLevel($activityLevel)) {
			switch($activityLevel) {
				case 'little':
					$TDEE = $BMR * 1.2;
					break;
				case 'light':
					$TDEE = $BMR * 1.375;
					break;
				case 'moderate':
					$TDEE = $BMR * 1.55;
					break;
				case 'heavy':
					$TDEE = $BMR * 1.725;
					break;
				case 'very_heavy':
					$TDEE = $BMR * 1.9;
					break;
			}
		}

		return $TDEE;
	}

	private function generateNotificationText($BMI, $BMR, $TDEE) {
		$message = array();

		if(!empty($BMI)) {
			$bmiRank = $this->getBMIRank($BMI);

			$message[] = '<span class="mkd-bmic-notification-highlight">'.esc_html__('You are ', 'mkd_bmi').$this->labels[$bmiRank].'! </span>';
			$message[] = esc_html__('Your BMI is ', 'mkd_bmi').$BMI.'. ';
		}

		if(!empty($BMR)) {
			$message[] = 'BMR '.$BMR.' '.esc_html__('kcal/day', 'mkd_bmi');
		}

		if(!empty($TDEE)) {
			$message[] = ', '.esc_html__('and', 'mkd_bmi').' BMR '.esc_html__('w/Activity Factor', 'mkd_bmi').' '.$TDEE.' '.esc_html__('kcal/day', 'mkd_bmi');
		}

		return implode('', $message);
	}

	private function getBMIRank($BMI) {
		if(!empty($BMI)) {
			if($BMI < 18.5) {
				return 'underweight';
			} elseif($BMI >= 18.5 && $BMI < 25) {
				return 'normal';
			} elseif($BMI >= 25 && $BMI < 30) {
				return 'overweight';
			} elseif($BMI >= 30) {
				return 'obese';
			}
		}

		return '';
	}

	private function setLabels() {
		$this->labels = array(
			'underweight' => esc_html__('Underweight', 'mkd_bmi'),
			'normal'      => esc_html__('Healthy', 'mkd_bmi'),
			'overweight'  => esc_html__('Overweight', 'mkd_bmi'),
			'obese'       => esc_html__('Obese', 'mkd_bmi')
		);
	}
}

BmiCalculatorApi::getInstance();