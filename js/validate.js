// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
**************************************************************************
**                              Plugin Name                             **
**************************************************************************
* @package     local                                                    **
* @subpackage  Placement                                                **
* @name        Placement                                                **
* @copyright   oohoo.biz                                                **
* @link        http://oohoo.biz                                         **
* @author      Stephane                                                 **
* @author      Fagnan                                                   **
* @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later **
**************************************************************************
**************************************************************************/

(function($) {
	$.fn.simpleValidate = function(options) {
		var opts = $.extend({}, $.fn.simpleValidate.defaults, options);

		return this.each(function() {
			var $this = $(this),
					o = $.meta ? $.extend({}, opts, $this.data()) : opts,
					errorMsgType = o.errorText.search(/{label}/);

			//When the form is submitted
			$this.bind('submit', function(e) {
				var hasError = false;

				//Hide any errors that are already showing
				$this.find(o.errorElement + '.' + o.errorClass).remove();
				$this.find(':input.' + o.inputErrorClass).removeClass(o.inputErrorClass);

				//Get all the required inputs
				$this.find(':input.required').each(function() {
					var $input = $(this),
							fieldValue = $.trim($input.val()),
							labelText = $input.siblings('label').text().replace(o.removeLabelChar, ''),
							errorMsg = '';

					//Check if it's empty or an invalid email
					if(fieldValue === '') {
					  errorMsg = (errorMsgType > -1 ) ? errorMsg = o.errorText.replace('{label}',labelText) : errorMsg = o.errorText;
						hasError = true;
					} else if($input.hasClass('email')) {
					  if(!(/^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/.test(fieldValue.toLowerCase()))) {
					    errorMsg = (errorMsgType > -1 ) ? errorMsg = o.emailErrorText.replace('{label}',labelText) : errorMsg = o.emailErrorText;
					    hasError = true;
					  }
					}

					//If there is an error, display it
					if(errorMsg !== '') {
					  $input.addClass(o.inputErrorClass).after('<'+o.errorElement+' class="'+o.errorClass+'">' + errorMsg + '</'+o.errorElement+'>');
					}
				});

				if(hasError) { //Don't submit the form if there are errors
					e.preventDefault();
				} else if(o.completeCallback !== '') { //If there is a callback
					o.completeCallback($this);
					if(o.ajaxRequest) { //If AJAX request
						e.preventDefault();
					}
				}
			});
		});
	};

	// default options
	$.fn.simpleValidate.defaults = {
		errorClass: 'error',
		errorText: 'this is a required field.',
		emailErrorText: 'Please enter a valid email',
		errorElement: 'strong',
		removeLabelChar: '*',
		inputErrorClass: '',
		completeCallback: '',
		ajaxRequest: false
	};
})(jQuery);