<?php

namespace App\Models\Commissary\Inventory\Traits\Attribute;

use App\Models\Commissary\Stock\Stock;

trait InventoryAttribute
{

	public function getEditButtonAttribute(){
		return '<a href="'.route('admin.commissary.inventory.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.edit').'"></i></a> ';
	}

	public function getDeleteButtonAttribute(){
		return '<a href="'.route('admin.commissary.inventory.destroy', $this).'"
                 data-method="delete"
                 data-trans-button-cancel="'.trans('buttons.general.cancel').'"
                 data-trans-button-confirm="'.trans('buttons.general.crud.delete').'"
                 data-trans-title="'.trans('strings.backend.general.are_you_sure').'"
                 class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.delete').'"></i></a> ';
	}

	public function getActionButtonsAttribute(){
		return $this->edit_button.$this->delete_button;
	}

	public function getAvailableStockAttribute(){
		return $this->stocks->where('status','NEW')->sum('quantity');
	}

	public function AddStock($val){
		return $this->attributes['stock'] = $this->stock + $val;
	}
}