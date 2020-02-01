<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 16.11.2018
 * Time: 13:15
 */

namespace app\system;


use yii\base\Arrayable;
use yii\base\Model;
use yii\data\DataProviderInterface;

class Serializer extends \yii\rest\Serializer
{
	/**
	 * Serializes the validation errors in a model.
	 * @param Model $model
	 * @return array the array representation of the errors
	 */
	protected function serializeModelErrors($model)
	{
		$this->response->setStatusCode(422, 'Data Validation Failed.');
		return [
			'success' => false,
			'message' => $model->getFirstErrors(),
			'data' => null,
		];
	}

	/**
	 * Serializes the given data into a format that can be easily turned into other formats.
	 * This method mainly converts the objects of recognized types into array representation.
	 * It will not do conversion for unknown object types or non-object data.
	 * The default implementation will handle [[Model]] and [[DataProviderInterface]].
	 * You may override this method to support more object types.
	 * @param mixed $data the data to be serialized.
	 * @return mixed the converted data.
	 */
	public function serialize($data)
	{
		if ($data instanceof Model && $data->hasErrors()) {
			return $this->serializeModelErrors($data);
		} elseif ($data instanceof Arrayable) {
			return $this->serializeModel($data);
		} elseif ($data instanceof DataProviderInterface) {
			return $this->serializeDataProvider($data);
		} elseif ($data instanceof \Throwable) {
			return $this->serilizeException($data);
		} else {
			return $this->serializeData($data);
		}

		return $data;
	}

	public function serializeData($data)
	{
		if (is_scalar($data)) {
			$result = ['result' => $data];
		} else {
			$result = $data;
		}

		return [
			'success' => true,
			'message' => null,
			'data' => $result,
		];
	}

	/**
	 * Serializes a model object.
	 * @param Arrayable $model
	 * @return array the array representation of the model
	 */
	protected function serializeModel($model)
	{
		if ($this->request->getIsHead()) {
			return null;
		}

		list($fields, $expand) = $this->getRequestedFields();
		return [
			'success' => true,
			'message' => null,
			'data' => $model->toArray($fields, $expand),
		];
	}

	/**
	 * @param \Throwable $exception
	 * @return array
	 */
	public function serilizeException($exception)
	{
		$status = $exception->getCode() === 0 ? 500 : $exception->getCode();
		$this->response->setStatusCode($status);
		return [
			'success' => false,
			'message' => $exception->getMessage(),
			'data' => null,
		];
	}
}