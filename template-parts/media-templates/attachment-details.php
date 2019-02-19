<?php
/**
 * The Attachment Details template, from wp-includes/media-template.php
 *
 * @package Civil_First_Fleet
 */

?>

<script type="text/html" id="tmpl-civil-attachment-details">
	<h2>
		<?php esc_html_e( 'Attachment Details', 'civil-cms' ); ?>
		<span class="settings-save-status">
			<span class="spinner"></span>
			<span class="saved"><?php esc_html_e( 'Saved.', 'civil-cms' ); ?></span>
		</span>
	</h2>
	<div class="attachment-info">
		<div class="thumbnail thumbnail-{{ data.type }}">
			<# if ( data.uploading ) { #>
				<div class="media-progress-bar"><div></div></div>
			<# } else if ( 'image' === data.type && data.sizes ) { #>
				<img src="{{ data.size.url }}" draggable="false" alt="" />
			<# } else { #>
				<img src="{{ data.icon }}" class="icon" draggable="false" alt="" />
			<# } #>
		</div>
		<div class="details">
			<div class="filename">{{ data.filename }}</div>
			<div class="uploaded">{{ data.dateFormatted }}</div>

			<div class="file-size">{{ data.filesizeHumanReadable }}</div>
			<# if ( 'image' === data.type && ! data.uploading ) { #>
				<# if ( data.width && data.height ) { #>
					<div class="dimensions">{{ data.width }} &times; {{ data.height }}</div>
				<# } #>

				<# if ( data.can.save && data.sizes ) { #>
					<a class="edit-attachment" href="{{ data.editLink }}&amp;image-editor" target="_blank"><?php esc_html_e( 'Edit Image', 'civil-cms' ); ?></a>
				<# } #>
			<# } #>

			<# if ( data.fileLength ) { #>
				<div class="file-length"><?php esc_html_e( 'Length:', 'civil-cms' ); ?> {{ data.fileLength }}</div>
			<# } #>

			<# if ( ! data.uploading && data.can.remove ) { #>
				<?php if ( MEDIA_TRASH ) : ?>
				<# if ( 'trash' === data.status ) { #>
					<button type="button" class="button-link untrash-attachment"><?php esc_html_e( 'Untrash', 'civil-cms' ); ?></button>
				<# } else { #>
					<button type="button" class="button-link trash-attachment"><?php esc_html_e( 'Trash', 'civil-cms' ); ?></button>
				<# } #>
				<?php else : ?>
					<button type="button" class="button-link delete-attachment"><?php esc_html_e( 'Delete Permanently', 'civil-cms' ); ?></button>
				<?php endif; ?>
			<# } #>

			<div class="compat-meta">
				<# if ( data.compat && data.compat.meta ) { #>
					{{{ data.compat.meta }}}
				<# } #>
			</div>
		</div>
	</div>

	<label class="setting" data-setting="url">
		<span class="name"><?php esc_html_e( 'URL', 'civil-cms' ); ?></span>
		<input type="text" value="{{ data.url }}" readonly />
	</label>
	<# var maybeReadOnly = data.can.save || data.allowLocalEdits ? '' : 'readonly'; #>
	<?php if ( post_type_supports( 'attachment', 'title' ) ) : ?>
	<label class="setting" data-setting="title">
		<span class="name"><?php esc_html_e( 'Title', 'civil-cms' ); ?></span>
		<input type="text" value="{{ data.title }}" {{ maybeReadOnly }} />
	</label>
	<?php endif; ?>
	<# if ( 'audio' === data.type ) { #>
	<?php
	foreach ( array(
		'artist' => __( 'Artist', 'civil-cms' ),
		'album'  => __( 'Album', 'civil-cms' ),
	) as $key => $label ) :
		?>
		<label class="setting" data-setting="<?php echo esc_attr( $key ); ?>">
			<span class="name"><?php echo esc_html( $label ); ?></span>
			<input type="text" value="{{ data.<?php echo esc_attr( $key ); ?> || data.meta.<?php echo esc_attr( $key ); ?> || '' }}" />
		</label>
	<?php endforeach; ?>
	<# } #>
	<label class="setting" data-setting="caption">
		<span class="name"><?php esc_html_e( 'Caption', 'civil-cms' ); ?></span>
		<textarea {{ maybeReadOnly }}>{{ data.caption }}</textarea>
	</label>
	<# if ( 'image' === data.type ) { #>
		<label class="setting" data-setting="alt">
			<span class="name"><?php esc_html_e( 'Alt Text', 'civil-cms' ); ?></span>
			<input type="text" value="{{ data.alt }}" {{ maybeReadOnly }} />
		</label>
	<# } #>
	<label class="setting" data-setting="description">
		<span class="name"><?php esc_html_e( 'Credit', 'civil-cms' ); ?></span>
		<textarea {{ maybeReadOnly }}>{{ data.description }}</textarea>
	</label>
</script>
