<!-- validates -->
<div id="info_content">
	<div id="profile_container">
		<img src="<?= base_url(); ?>assets/images/header_schoolman.png" alt="Profiel" />
		<p class="clearfix"></p>
		<div id="profile_left">
			<ul class="profile_links">
				<li><a href="/school/index/data" name="personal">Schoolgegevens</a></li>
				<li><a href="/school/index/richting" name="school">Studierichtingen</a></li>
			</ul>
		</div>
		
		<div id="profile_right">
			<div class="form_school" style="display: block">
				<img src="<?= base_url(); ?>assets/images/edit_school.png" alt="Schoolgegevens aanpassen" />
				<?= form_open('student/save_school')?>
					<p>
						<label for="school">School:</label>
						<input type="text" name="school" id="school" />
						<input type="hidden" name="school_id" id="school_id"  />
					</p>
					<p>
						<label for="richting">Studierichting:</label>
						<input type="text" name="richting" id="richting" />
						<input type="hidden" name="richting_id" id="richting_id"/>
					</p>
					<p>
						<label for="leerkracht">Coach:</label>
						<input type="text" name="leerkracht" id="leerkracht" disabled="disabled"  />
					</p>
					<p class="buttons">
						<input type="submit" id="saveSchool" name="saveSchool" value="Opslaan" />
					</p>
				</form>
			</div>
		</div>
	</div>
</div>