<!-- validates -->
<div id="info_content">
	<div id="profile_container">
		<img src="<?= base_url(); ?>assets/images/informatie_header.png" alt="Informatie" />
		<p class="clearfix"></p>
		<div id="profile_left">
			<ul class="profile_links">
				<li><a href="#" name="personal">Tips en technieken</a></li>
			</ul>
		</div>
		
		<div id="profile_right">
			<div class="form_profile">
				<img src="<?= base_url(); ?>assets/images/header_tips.png" alt="Persoonlijke gegevens aanpassen" />
				<ul id="items_list">
					<? foreach($content as $item): ?>
						<li><a href="<?= base_url(); ?>files/<?= $item['content']; ?>"><?= $item['title']; ?></a></li>
					<? endforeach; ?>
				</ul>
				<br />
				<h2 id="upload">Hier kan u een nieuwe tip uploaden:</h2>
				
			
				<?php echo form_open_multipart('informatie/upload_file');?>
				
				<p>
					<label for="title">Titel:</label>
					<input type="text" name="title" id="title" />
				</p>			
				<p>
				<label for="userfile">Bestand:</label>
				<input type="file" name="userfile" size="20" id="userfile" style="float: right"/>
				</p>
				<p class="clearfix buttons">
				<input type="submit" value="Uploaden" />
				</p>
				<?= form_close();?>
				<p id="upload_feedback">
					<? if($this->session->flashdata('upload')){ echo $this->session->flashdata('upload');}?>
				</p>
			</div>
		</div>
	</div>
</div>