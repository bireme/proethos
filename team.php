<script type="text/javascript">
	function lookup(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
			$.post("team_search_ajax.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
				}
			});
		}
	} // lookup
	
	function fill(thisValue) {
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);
	}
</script>
<?php
$s .= '<div><form><div>';
$s .= msg('team_institution');
$s .= '<br /><input type="text" size="60" value="" id="inputString" style="width: 100%" onkeyup="lookup(this.value);" onblur="fill();" />';
$s .= '</div>';
$s .= '<div class="suggestionsBox" id="suggestions" style="display: none;">
				<img src="img/SetaUp.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
				<div class="suggestionList" id="autoSuggestionsList">
					&nbsp;
				</div>
			</div>
		</form>
	</div>
	';
?>
