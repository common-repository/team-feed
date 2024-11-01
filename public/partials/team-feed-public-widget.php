<?php

/**
 * Provide a public-facing view for the widget
 *
 * This file is used to markup the public-facing aspects of the widget.
 *
 * @link       http://www.egirna.com
 * @since      1.0.0
 *
 * @package    Team_Feed
 * @subpackage Team_Feed/public/partials
 */

	$instance = wp_parse_args(
		(array)$instance,
		array(
			'history' => ''
		)
	);

	// Channel history API file
	include plugin_dir_path( __FILE__ ) . 'apis/team-feed-public-channel-history.php';

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div>
	<h2><?php _e($instance['name'], 'team_feed_widget'); ?></h2>

	<?php if ($instance['history'] != "No history found or invalid data"): { ?>

	<div id="<?php echo $this->get_field_id('history'); ?>" class="team-feed-channel">
		<ul id="team-feed-channel">

				<?php foreach ($instance['history'] as $history): ?>

					<li>
						<!-- Show users name and profiles-->
						<img id="profile" src="<?php print_r($history['users'][0]['profile']['image_48']) ?>">
						<span><?php print_r($history['users'][0]['name']); ?></span>

						<!-- Check post does not has an upload file-->
						<?php if ($history['text'] && strpos($history['text'], 'uploaded a file') == false): { ?>

							<!-- Check if post has a youtube video-->
							<?php if (strpos($history['text'], 'youtube') != false): { ?>
								<?php $reg_exUrl = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i"; ?>
								<?php preg_match($reg_exUrl, $history['text'], $url) ?>

								<!-- Appear Text if set-->
								<?php print_r(strip_tags($history['text'])); ?>

								<!-- Appear Title and image of video-->
								<a href="<?php echo $url[0]; ?>" target="_blank">
									<?php foreach ($history['attachments'] as $key => $value): ?>
										<?php if ($key == "title"): ?>
											<p>
												<?php print_r($value['title']); ?>
											</p>
										<?php endif ?>
										<?php if ($key == "thumb_url"): ?>
											<img class="image-post" src="<?php print_r($value['thumb_url']); ?>">
										<?php endif ?>
									<?php endforeach ?>
								</a>

								<!-- Check post does not has an upload file and youtube video-->
							<?php } else: { ?>
								<?php $reg_exUrl = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i"; ?>
								<!-- Check post has links and does not has comments-->
								<?php if (preg_match($reg_exUrl, $history['text'], $url)):{ ?>

									<P>
										<?php print_r(strip_tags($history['text'])); ?>
										<a href="<?php print_r($url[0]); ?>" target="_blank"><?php print_r($url[0]); ?></a>
									</P>

									<!-- Else this is a normal post -->
								<?php }else: ?>

									<?php $text = strip_tags($history['text']);?>
									<?php if (strlen( $text) > 150 ):
										// Truncate the text
										$FirstTextCut = substr( $text, 0, 150 );
										$SecondTextCut = substr( $text, 150, 1000 );
									?>

										<div>
											<?php print_r($FirstTextCut);?>...
											<?php $num = rand(); ?>
											<a id="continue-reading.<?php echo $num; ?>" class="continue-reading" onclick="ShowAllParagraph('bioSecondHalf.<?php echo $num; ?>','continue-reading.<?php echo $num; ?>')">Continue reading</a>
											<div id="bioSecondHalf.<?php echo $num; ?>" style="display:none"> <?php print_r($SecondTextCut);?></div>
										</div>
									<?php else: ?>
										<p>
											<?php print_r(strip_tags($history['text'])); ?>
										</p>
									<?php endif ?>
								<?php endif ?>
							<?php }endif ?>

							<!-- Check if post has an upload file-->
						<?php }else: { ?>

							<!-- Appear gif upload file-->
							<a href="<?php echo $history['file']['public_image_link']; ?>" target="_blank">
								<img class="image-post" src="<?php echo $history['file']['public_image_link']; ?>">
							</a>

							<!-- Check if upload file has comments -->
							<?php if (isset($history['file']['comments_count']) and $history['file']['comments_count'] != 0 ):{ ?>
								<p id="comment">
									<?php print_r(strip_tags($history['file']['initial_comment']['comment'])); ?>
								</p>

							<?php } elseif(isset($history['comment']['comment']) and $history['comment']['comment'] != ""): ?>
								<p id="comment">
									<?php print_r(strip_tags($history['comment']['comment'])); ?>
								</p>
							<?php endif ?>

						<?php }endif ?>
					</li>
				<?php endforeach ?>

		</ul>
	</div>

	<!-- Check if is admin user to history error display-->
	<?php } elseif ( current_user_can( 'administrator' ) ): { ?>

		<div id="<?php echo $this->get_field_id('history'); ?>" class="team-feed-channel">
			<p class="Nohistory">
				<?php print_r($instance['history']); } ?>
			</p>
		</div>

	<!-- Check if is a normal user to display team feed logo-->
	<?php  else: { ?>
		<div class="pic-error"></div>
	<?php }endif ?>
</div>