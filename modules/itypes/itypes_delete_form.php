<div id="deleteModal<?= $i ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Suppression d'un type d'identification</h4>
			</div> <!-- modal-header -->

			<div class="modal-body">
				<p>Êtes-vous sûr(e) de vouloir supprimer <strong>"<?= htmlspecialchars($row['nom']) ?>"</strong> ?</p>
			</div> <!-- modal-body -->

			<div class="modal-footer">
				<form method="post" action="itypes_delete.php?tid=<?= $row['tid'] ?>" class="form-inline">
					<input type="submit" name="delete" value="Supprimer" class="btn btn-danger">
					<button type="button" class="btn btn-basic" data-dismiss="modal">Annuler</button>
				</form>
			</div> <!-- modal-footer -->
		</div> <!-- modal-content -->
	</div> <!-- modal-dialog -->
</div> <!-- id deleteModal -->
