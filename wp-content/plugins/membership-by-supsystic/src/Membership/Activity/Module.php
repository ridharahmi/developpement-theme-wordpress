<?php

class Membership_Activity_Module extends Membership_Base_Module {

	public function afterModulesLoaded() {
		$this->registerShortcodes();
		$this->registerAjaxRoutes();
		$this->registerTwigExtension();
		add_action('template_redirect', array($this, 'onTemplateRedirect'));
		add_action('setup_theme', array($this, 'registerRewriteRules'));
		$dispatcher = $this->getDispatcher();
		$dispatcher->on('createActivity', array($this, 'onCreateActivity'));
		add_action('widgets_init', array($this, 'widgetsInit'));

		$routesModule = $this->getModule('routes');

		$routesModule->registerOnRequestAction(
			array(
				array($this, 'onRequest')
			)
		);

	}

	public function widgetsInit() {
		global $wp_widget_factory;
		$wp_widget_factory->widgets['Membership_Activity_Widgets_PopularActivities'] = new Membership_Activity_Widgets_PopularActivities($this);
	}

	public function onRequest($query, $requestedPageId, $routesList) {

		if (@($routesList['activity'] == $requestedPageId) || @($routesList['search'] == $requestedPageId)) {
			$this->enqueueActivitiesAssets();
		}

		if (@($routesList['search'] == $requestedPageId)) {
			$this->getModule('assets')->enqueueAssets(
				array(),
				array(
					$this->getAssetsPath() . '/js/search.frontend.js'
				),
				MBS_FRONTEND
			);
		}

		return $query;
	}

	public function enqueueActivitiesAssets() {

		$assetsPath = $this->getAssetsPath();
		$baseModule = $this->getModule('Base');
		$baseAssetsPath = $baseModule->getAssetsPath();

		$this->getModule('assets')->enqueueAssets(
			array(
				array(
					'source' => $assetsPath . '/css/activity.frontend.css',
					'dependencies' => array(
						'semantic-ui',
					)
				)
			),
			array(
				$baseAssetsPath . '/lib/jquery.history.js',
				$baseAssetsPath . '/lib/moment/moment.min.js',
				$baseAssetsPath . '/lib/moment/locales.min.js',
				$baseAssetsPath . '/lib/imagesloaded.pkgd.min.js',
				$baseAssetsPath . '/lib/fileupload/jquery.iframe-transport.min.js',
				$baseAssetsPath . '/lib/fileupload/jquery.ui.widget.min.js',
				$baseAssetsPath . '/lib/fileupload/jquery.fileupload.min.js',
				$assetsPath . '/js/activity.frontend.js'
			),
			MBS_FRONTEND
		);

		$this->getDispatcher()->dispatch('activity.enqueueActivitiesAssets');
	}

	public function registerAjaxRoutes() {

        $settings = $this->getSettings();

        if ($settings['base']['main']['activity'] === 'true') {
            $routesModule = $this->getModule('routes');

            $routesModule->registerAjaxRoutes(array(

                'activity.get' => array(
                    'method' => 'get',
                    'handler' => array($this->getController(), 'getActivity'),
                    'guest' => true
                ),
                'activity.post' => array(
                    'method' => 'post',
                    'handler' => array($this->getController(), 'postActivity')
                ),
                'activity.update' => array(
                    'method' => 'post',
                    'handler' => array($this->getController(), 'updateActivity')
                ),
                'activity.setStatus' => array(
                    'method' => 'post',
                    'handler' => array($this->getController(), 'setStatus'),
                    'admin' => true
                ),
                'activity.comments.get' => array(
                    'method' => 'get',
                    'handler' => array($this->getController(), 'getComments'),
                    'guest' => true
                ),
                'activity.comments.post' => array(
                    'method' => 'post',
                    'handler' => array($this->getController(), 'createComment')
                ),
                'activity.comments.reply' => array(
                    'method' => 'post',
                    'handler' => array($this->getController(), 'replyComment')
                ),

                'comments.remove' => array(
                    'method' => 'post',
                    'handler' => array($this->getController(), 'removeComment')
                ),
                'comments.update' => array(
                    'method' => 'post',
                    'handler' => array($this->getController(), 'updateComment')
                ),
                'comments.replies' => array(
                    'method' => 'get',
                    'handler' => array($this->getController(), 'getCommentReplies'),
                    'guest' => true
                ),

                'activity.like' => array(
                    'method' => 'post',
                    'handler' => array($this->getController(), 'likeActivity')
                ),
                'activity.unlike' => array(
                    'method' => 'post',
                    'handler' => array($this->getController(), 'unlikeActivity')
                ),
                'activity.likes.get' => array(
                    'method' => 'get',
                    'handler' => array($this->getController(), 'getLikes'),
                    'guest' => true
                ),
                'activity.share' => array(
                    'method' => 'post',
                    'handler' => array($this->getController(), 'shareActivity')
                ),
                'activity.shares.get' => array(
                    'method' => 'get',
                    'handler' => array($this->getController(), 'getShares'),
                    'guest' => true
                ),
                'activity.remove' => array(
                    'method' => 'post',
                    'handler' => array($this->getController(), 'removeActivity')
                ),
                'activity.parseUrlAttachment' => array(
                    'method' => 'get',
                    'handler' => array($this->getController(), 'parseUrlAttachment')
                ),
                'activity.search' => array(
                    'method' => 'get',
	                'guest' => 'true',
                    'handler' => array($this->getController(), 'search')
                ),
            ));
        }
	}

	public function registerShortcodes() {
		add_shortcode($this->getConfig('shortcode_name') . '-activity',
			array($this, 'activityShortcodeHandler'));

		add_shortcode($this->getConfig('shortcode_name') . '-profile-activity',
			array($this, 'profileActivityShortcodeHandler'));

		add_shortcode($this->getConfig('shortcode_name') . '-search',
			array($this, 'searchShortcodeHandler'));
	}

	public function onCreateActivity($activity) {
		$this->getModel('Tags', 'activity')->parseActivityData($activity);
	}

	public function registerRewriteRules() {
		//
	}

	public function registerTwigExtension() {
		$this->getTwig()->addExtension(new Membership_Activity_Twig($this));
	}

	public function activityShortcodeHandler($attributes) {
		$error = false;

		if (!$this->getModule('users')->currentUserCan('access-to-global-activity-page')) {
			$error = $this->translate('Your account don\'t have permission to see activity page');
		}

		$settings = $this->getSettings();

		if ($settings['base']['main']['activity'] === 'false') {
			$error = $this->translate('Community activity is disabled');
		}

		if ($error) {
			return $this->render('@base/error.twig', array('error' => $error));
		}

		$activityModel = $this->getModel('Activity', 'Activity');
		$activityFilterEnabled = $settings['design']['activity']['show-filter'] === 'true';
		$activityFilter = $settings['design']['activity']['default-filter'];
		$activityTypes = $activityModel->getActivityTypesFromSettings($settings['design']['activity']['type']);
		$smilesList = $activityModel->getSmilesList();
		$currentUserId = get_current_user_id();

		if (! is_user_logged_in() && $activityFilter === 'subscriptions') {
			$activityFilter = 'site-wide';
		}

		if (!is_user_logged_in() || $activityFilter === 'site-wide') {
			$currentUserId = null;
		}

		if ($activityFilter === 'popular') {
			$activities = $activityModel->getPopularActivities(array(
				'since' => 0,
				'limit' => 5,
				'activityTypes' => $activityTypes,
			));
		} else {
			$activities = $activityModel->getActivity(array(
				'userId' => $currentUserId,
				'limit' => 5,
				'activityTypes' => $activityTypes,
				'activityFilter' => $activityFilter,
			));
		}

		return $this->render('@activity/index.twig', array(
			'activities' => $activities,
			'activityFilter' => $activityFilter,
			'activityTypes' => $activityTypes,
			'activityAllTypes' => $activityModel->getAllActivityTypes(),
			'activityFilterEnabled' => $activityFilterEnabled,
			'smilesList' => $smilesList,
		));
	}

	public function profileActivityShortcodeHandler($params) {
		$error = false;

		if (!$this->getModule('users')->currentUserCan('access-to-profile-activity-page')) {
			$error = $this->translate('Your account don\'t have permission to see activity page');
		}

		$settings = $this->getSettings();

		if ($settings['base']['main']['activity'] === 'false') {
			$error = $this->translate('Community activity is disabled');
		}

		if ($error) {
			return $this->render('@base/error.twig', array('error' => $error));
		}

		$activityModel = $this->getModel('Activity', 'Activity');
		$activities = $activityModel->getActivity(array('userId' => $this->requestedUser['id'], 'limit' => 5));

		return $this->render('@activity/profile-activity.twig', array('activities' => $activities));
	}

	public function searchShortcodeHandler() {

		$query = $this->getRequest()->query->get('q', null);
		$type = $this->getRequest()->query->get('type', null);

		$activities = array();

		if ($query && $type) {
			$activityModel = $this->getModel('Activity', 'Activity');
			$activities = $activityModel->searchInActivities($query, $type, get_current_user_id(), 5);
		}

		return $this->render('@activity/search.twig', array(
			'activities' => $activities
		));
	}

	/**
	 * This is used to render global activity or user activity by shortcode on any page
	 * e.g. of shortcodes [supsystic-membership-activity] [supsystic-membership-profile-activity id="1"]
	 */
	public function onTemplateRedirect() {
		global $post;
		$routesModule = $this->getModule('routes');
		$settings = $this->getSettings();

		if (is_a($post, 'WP_Post') ) {
			$activityShortcode = $this->getConfig('shortcode_name') . '-activity';
			$userActivityShortcode = $this->getConfig('shortcode_name') . '-profile-activity';

			$pattern = get_shortcode_regex();
			if (preg_match_all('/'. $pattern .'/s', $post->post_content, $shortcodes)) {
				if ($shortcodes) {
					if (in_array($activityShortcode, $shortcodes[2]) || in_array($userActivityShortcode, $shortcodes[2])) {
						if (!is_user_logged_in() && $settings['base']['security']['global-site-access'] !== 'everyone') {
							wp_redirect($routesModule->getRouteUrl('login'));
							die();
						}
					}


					foreach($shortcodes[2] as $key => $shortcodeName) {

						if ($shortcodeName == $userActivityShortcode) {
							$shortCodeAttr = shortcode_parse_atts($shortcodes[3][$key]);
							if (isset($shortCodeAttr['id'])) {

								$this->requestedUser = $this->getModel('Profile', 'Users')->getUserById($shortCodeAttr['id']);

								$this->getTwig()->addGlobal('requestedUser',  $this->requestedUser);
								$this->enqueueActivitiesAssets();

								$this->registerFrontendData(array('requestedUser' => array(
									'id' => $this->requestedUser['id'],
									'displayName' => $this->requestedUser['displayName'],
								)));

								return;
							}
						}

						if ($shortcodeName == $activityShortcode) {
							$this->enqueueActivitiesAssets();
							return;
						}

					}
				}
			}

		}
	}

	public function getActivityUrlById($id){
	    /**
         * @var $activityModel Membership_Activity_Model_Activity
         * @var $groupsModule Membership_Groups_Module
         */
        $groupsModule= $this->getModule('Groups');
	    $activityModel = $this->getModel('Activity', 'Activity');
	    $activity = $activityModel->getActivityById($id, get_current_user_id());
	    $activity = array_pop($activity);

	    if(is_null($activity)) return '';

        $permalinkStructure = get_option('permalink_structure');

	    $params = implode('=', array('activity', $id));
	    $groupId = (int)$activity['object_id'];
	    $groupUrl = $groupsModule->getGroupUrlById($groupId);

        if($permalinkStructure){
            $return = $groupUrl . implode('/', array('activity', $activity['id']));
        }else{
            $return = implode('&', array($groupUrl, $params));
        }
        
	    return $return;
    }

    public function getGroupPermalinkBase() {
        $settings = $this->getSettings();

        return $settings['groups']['permalink-base'];
    }

    public function isPostComment($group){
        /**
         * @var $usersModule Membership_Users_Module
         */

        if(empty($group)) return true;

	    $commentsMode = $group['settings']['post-comments'];
	    $isFollower =  (boolean)$group['currentUserIsFollowing'];
	    $usersModule = $this->getModule("Users");

        switch ($commentsMode){
            case 'members-only':
                return $isFollower || $usersModule->isAdmin();
                break;
            case 'administrators':
                return $usersModule->isAdmin();
                break;
            default:
                return true;
        }
    }
}