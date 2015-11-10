<form method="post" action="" class="sap-form form-horizontal">
	{preventCsrf}

	<div class="wrap-list">
		<div class="wrap-group">
			<div class="wrap-group-heading">
				<h4>{lang key='configure_langs'} <small>{lang key='manage_langs'}</small></h4>
			</div>

			{foreach $google_langs as $k => $v}
				<div class="row">
					<label class="col col-lg-2 control-label">{$v.title}</label>
					<div class="col col-lg-4">
						<div class="input-group">
							<input type="text" name="label[{$k}]" value="{$v.title}">
							<span class="input-group-addon">
								<input type="checkbox" name="google_lang[]" value="{$k}" {$v.checked}> 
							</span>
						</div>
					</div>
				</div>
			{/foreach}

		</div>

		<div class="form-actions inline">
			<button type="submit" name="save" class="btn btn-primary">{lang key='save_changes'}</button>
		</div>
	</div>
</form>