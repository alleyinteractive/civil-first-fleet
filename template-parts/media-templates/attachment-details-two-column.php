<?php
/**
 * The Attachment Details - Two Column template, from wp-includes/media-template.php
 *
 * @package Civil_First_Fleet
 */

?>

<script type="text/html" id="tmpl-civil-attachment-details-two-column">
	<div class="attachment-media-view {{ data.orientation }}">
		<div class="thumbnail thumbnail-{{ data.type }}">
			<# if ( data.uploading ) { #>
				<div class="media-progress-bar"><div></div></div>
			<# } else if ( data.sizes && data.sizes.large ) { #>
				<img class="details-image" src="{{ data.sizes.large.url }}" draggable="false" alt="" />
			<# } else if ( data.sizes && data.sizes.full ) { #>
				<img class="details-image" src="{{ data.sizes.full.url }}" draggable="false" alt="" />
			<# } else if ( -1 === jQuery.inArray( data.type, [ 'audio', 'video' ] ) ) { #>
				<img class="details-image icon" src="{{ data.icon }}" draggable="false" alt="" />
			<# } #>

			<# if ( 'audio' === data.type ) { #>
			<div class="wp-media-wrapper">
				<audio style="visibility: hidden" controls class="wp-audio-shortcode" width="100%" preload="none">
					<source type="{{ data.mime }}" src="{{ data.url }}"/>
				</audio>
			</div>
			<# } else if ( 'video' === data.type ) {
				var w_rule = '';
				if ( data.width ) {
					w_rule = 'width: ' + data.width + 'px;';
				} else if ( wp.media.view.settings.contentWidth ) {
					w_rule = 'width: ' + wp.media.view.settings.contentWidth + 'px;';
				}
			#>
			<div style="{{ w_rule }}" class="wp-media-wrapper wp-video">
				<video controls="controls" class="wp-video-shortcode" preload="metadata"
					<# if ( data.width ) { #>width="{{ data.width }}"<# } #>
					<# if ( data.height ) { #>height="{{ data.height }}"<# } #>
					<# if ( data.image && data.image.src !== data.icon ) { #>poster="{{ data.image.src }}"<# } #>>
					<source type="{{ data.mime }}" src="{{ data.url }}"/>
				</video>
			</div>
			<# } #>

			<div class="attachment-actions">
				<# if ( 'image' === data.type && ! data.uploading && data.sizes && data.can.save ) { #>
				<button type="button" class="button edit-attachment"><?php esc_html_e( 'Edit Image', 'civil-first-fleet' ); ?></button>
				<# } else if ( 'pdf' === data.subtype && data.sizes ) { #>
				<?php esc_html_e( 'Document Preview', 'civil-first-fleet' ); ?>
				<# } #>
			</div>
		</div>
	</div>
	<div class="attachment-info">
		<span class="settings-save-status">
			<span class="spinner"></span>
			<span class="saved"><?php esc_html_e( 'Saved.', 'civil-first-fleet' ); ?></span>
		</span>
		<div class="details">
			<div class="filename"><strong><?php esc_html_e( 'File name:', 'civil-first-fleet' ); ?></strong> {{ data.filename }}</div>
			<div class="filename"><strong><?php esc_html_e( 'File type:', 'civil-first-fleet' ); ?></strong> {{ data.mime }}</div>
			<div class="uploaded"><strong><?php esc_html_e( 'Uploaded on:', 'civil-first-fleet' ); ?></strong> {{ data.dateFormatted }}</div>

			<div class="file-size"><strong><?php esc_html_e( 'File size:', 'civil-first-fleet' ); ?></strong> {{ data.filesizeHumanReadable }}</div>
			<# if ( 'image' === data.type && ! data.uploading ) { #>
				<# if ( data.width && data.height ) { #>
					<div class="dimensions"><strong><?php esc_html_e( 'Dimensions:', 'civil-first-fleet' ); ?></strong> {{ data.width }} &times; {{ data.height }}</div>
				<# } #>
			<# } #>

			<# if ( data.fileLength ) { #>
				<div class="file-length"><strong><?php esc_html_e( 'Length:', 'civil-first-fleet' ); ?></strong> {{ data.fileLength }}</div>
			<# } #>

			<# if ( 'audio' === data.type && data.meta.bitrate ) { #>
				<div class="bitrate">
					<strong><?php esc_html_e( 'Bitrate:', 'civil-first-fleet' ); ?></strong> {{ Math.round( data.meta.bitrate / 1000 ) }}kb/s
					<# if ( data.meta.bitrate_mode ) { #>
					{{ ' ' + data.meta.bitrate_mode.toUpperCase() }}
					<# } #>
				</div>
			<# } #>

			<div class="compat-meta">
				<# if ( data.compat && data.compat.meta ) { #>
					{{{ data.compat.meta }}}
				<# } #>
			</div>
		</div>

		<div class="settings">
			<label class="setting" data-setting="url">
				<span class="name"><?php esc_html_e( 'URL', 'civil-first-fleet' ); ?></span>
				<input type="text" value="{{ data.url }}" readonly />
			</label>
			<# var maybeReadOnly = data.can.save || data.allowLocalEdits ? '' : 'readonly'; #>
			<?php if ( post_type_supports( 'attachment', 'title' ) ) : ?>
			<label class="setting" data-setting="title">
				<span class="name"><?php esc_html_e( 'Title', 'civil-first-fleet' ); ?></span>
				<input type="text" value="{{ data.title }}" {{ maybeReadOnly }} />
			</label>
			<?php endif; ?>
			<# if ( 'audio' === data.type ) { #>
			<?php
			foreach ( array(
				'artist' => __( 'Artist', 'civil-first-fleet' ),
				'album'  => __( 'Album', 'civil-first-fleet' ),
			) as $key => $label ) :
				?>
				<label class="setting" data-setting="<?php echo esc_attr( $key ); ?>">
					<span class="name"><?php echo esc_html( $label ); ?></span>
					<input type="text" value="{{ data.<?php echo esc_attr( $key ); ?> || data.meta.<?php echo esc_attr( $key ); ?> || '' }}" />
				</label>
			<?php endforeach; ?>
			<# } #>
			<label class="setting" data-setting="caption">
				<span class="name"><?php esc_html_e( 'Caption', 'civil-first-fleet' ); ?></span>
				<textarea {{ maybeReadOnly }}>{{ data.caption }}</textarea>
			</label>
			<# if ( 'image' === data.type ) { #>
				<label class="setting" data-setting="alt">
					<span class="name"><?php esc_html_e( 'Alt Text', 'civil-first-fleet' ); ?></span>
					<input type="text" value="{{ data.alt }}" {{ maybeReadOnly }} />
				</label>
			<# } #>
			<label class="setting" data-setting="description">
				<span class="name"><?php esc_html_e( 'Credit', 'civil-first-fleet' ); ?></span>
				<textarea {{ maybeReadOnly }}>{{ data.description }}</textarea>
			</label>
			<label class="setting">
				<span class="name"><?php esc_html_e( 'Uploaded By', 'civil-first-fleet' ); ?></span>
				<span class="value">{{ data.authorName }}</span>
			</label>
			<# if ( data.uploadedToTitle ) { #>
				<label class="setting">
					<span class="name"><?php esc_html_e( 'Uploaded To', 'civil-first-fleet' ); ?></span>
					<# if ( data.uploadedToLink ) { #>
						<span class="value"><a href="{{ data.uploadedToLink }}">{{ data.uploadedToTitle }}</a></span>
					<# } else { #>
						<span class="value">{{ data.uploadedToTitle }}</span>
					<# } #>
				</label>
			<# } #>
			<div class="attachment-compat"></div>
		</div>

		<div class="actions">
			<a class="view-attachment" href="{{ data.link }}"><?php esc_html_e( 'View attachment page', 'civil-first-fleet' ); ?></a>
			<# if ( data.can.save ) { #> |
				<a href="post.php?post={{ data.id }}&action=edit"><?php esc_html_e( 'Edit more details', 'civil-first-fleet' ); ?></a>
			<# } #>
			<# if ( ! data.uploading && data.can.remove ) { #> |
				<?php if ( MEDIA_TRASH ) : ?>
					<# if ( 'trash' === data.status ) { #>
						<button type="button" class="button-link untrash-attachment"><?php esc_html_e( 'Untrash', 'civil-first-fleet' ); ?></button>
					<# } else { #>
						<button type="button" class="button-link trash-attachment"><?php esc_html_e( 'Trash', 'civil-first-fleet' ); ?></button>
					<# } #>
				<?php else : ?>
					<button type="button" class="button-link delete-attachment"><?php esc_html_e( 'Delete Permanently', 'civil-first-fleet' ); ?></button>
				<?php endif; ?>
			<# } #>
		</div>

	</div>
</script>
