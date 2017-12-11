<?php

namespace App\Models\Commissary\Produce\Traits\Attribute;

trait ProduceAttribute
{
	public function getDeleteButtonAttribute(){
		return '<a href="'.route('admin.commissary.produce.destroy', $this).'"
                 data-method="delete"
                 data-trans-button-cancel="'.trans('buttons.general.cancel').'"
                 data-trans-button-confirm="'.trans('buttons.general.crud.delete').'"
                 data-trans-title="'.trans('strings.backend.general.are_you_sure').'"
                 class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.delete').'"></i></a> ';
	}

	public function getActionButtonsAttribute(){
		return $this->view_button.$this->edit_button.$this->delete_button;
	}

	public function addProduce($val){
		return $this->attributes['produce'] = $this->produce + $val;
	}
}