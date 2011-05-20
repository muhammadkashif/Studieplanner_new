<!-- validates -->
<div id="info_content">
	<div id="profile_container">
		<img src="<?= base_url(); ?>assets/images/lln_beheer.png" alt="Leerlingen beheer" />
		<p class="clearfix"></p>
		<div id="profile_left">
			<ul class="profile_links">
				<li><a href="/school/index/data" name="personal">Mijn leerlingen</a></li>
				<li><a href="/school/index/richting" name="school">Taak plannen</a></li>
			</ul>
		</div>
		
		<div id="profile_right">
			<div class="users_per_school">
				<img src="<?= base_url(); ?>assets/images/mijn_lln.png" alt="Mijn leerlingen" />
				<table class="tbl_students">
					<tr>
						<th>Achternaam</th>
						<th>Voornaam</th>
						<th>E-mail</th>
						<th>Studierichting</th>
					</tr>
					<? foreach($leerlingen as $leerling): ?>
						<tr>
							<td><?= $leerling['achternaam']; ?></td>
							<td><?= $leerling['voornaam']; ?></td>
							<td><?= $leerling['email']; ?></td>
							<td><?= $leerling['studierichting']; ?></td>
						</tr>
					<? endforeach;?>
				</table>
			</div>

			<div class="form_school">
				<img src="<?= base_url(); ?>assets/images/edit_school.png" alt="Schoolgegevens aanpassen" />
				<?= form_open('school/add_studierichting', array('id' => 'formLkrAddRichting')); ?>
					<p>
						<label for="naam">Studierichting:</label>
						<input type="text" name="naam" id="richting" />
					</p>
					<p class="buttons">
						<input type="submit" id="add_studierichting" value="Opslaan" />
					</p>
				</form>
				<p class="clearfix"></p>
			 	<div>
					<h2 class="richting">
						<img src="<?= base_url(); ?>assets/images/school_richtingen.png" alt="Studierichtingen">
					</h2>
				
				</div>
			</div>
		</div>
	</div>
</div>