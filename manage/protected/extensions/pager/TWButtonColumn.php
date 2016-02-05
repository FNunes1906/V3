<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class TWButtonColumn extends CButtonColumn {

    protected function initDefaultButtons()
	{
		if($this->deleteConfirmation===null)
			$this->deleteConfirmation=Yii::t('zii','Are you sure you want to delete this item?');

		if(!isset($this->buttons['delete']['click']))
		{
			if(Yii::app()->request->enableCsrfValidation)
			{
				$csrfTokenName = Yii::app()->request->csrfTokenName;
				$csrfToken = Yii::app()->request->csrfToken;
				$csrf = "\n\t\tdata:{ '$csrfTokenName':'$csrfToken' },";
			}
			else
				$csrf = '';

			if($this->afterDelete===null)
				$this->afterDelete='function(){}';

			$this->buttons['delete']['click']=<<<JavaScript
function() {
        var th = this;
        var afterDelete = $this->afterDelete;

        bootbox.confirm('$this->deleteConfirmation', function(result) {
            if(result == true) {
                jQuery('#{$this->grid->id}').yiiGridView('update', {
                    type: 'POST',
                    url: jQuery(th).attr('href'),$csrf
                    success: function(data) {
                        jQuery('#{$this->grid->id}').yiiGridView('update');
                        afterDelete(th, true, data);
                    },
                    error: function(XHR) {
                        return afterDelete(th, false, XHR);
                    }
                });
            }
        });
	return false;
}
JavaScript;
		}

		parent::initDefaultButtons();
	}
}
?>
