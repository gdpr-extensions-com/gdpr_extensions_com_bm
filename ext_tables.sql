CREATE TABLE tx_gdprextensionscombm_domain_model_localbanner (
	banner_id int(11) NOT NULL DEFAULT '0',
	banner_title varchar(255) NOT NULL DEFAULT '',
	banner_html text NOT NULL DEFAULT '',
	banner_css text NOT NULL DEFAULT '',
	banner_js text NOT NULL DEFAULT '',
	valid_from int(11) NOT NULL DEFAULT '0',
	valid_to int(11) NOT NULL DEFAULT '0',
	root_pid varchar(255) NOT NULL DEFAULT '',
	campaign_id varchar(255) NOT NULL DEFAULT '',
	is_archived int(11) NOT NULL DEFAULT '0',
	campaign_is_disabled int(11) NOT NULL DEFAULT '0',
	dashboard_api_key varchar(255) NOT NULL DEFAULT '',
);

CREATE TABLE tx_gdprextensionscombm_domain_model_bannerstat (
	 impressions int(11) NOT NULL DEFAULT '0',
	 timestamp int(11) NOT NULL DEFAULT '0',
	 local_banner int(11) unsigned DEFAULT '0'
);

CREATE TABLE tt_content (
		enable_slider int(11) NOT NULL DEFAULT '0',
		business_locations_banner varchar(255) NOT NULL DEFAULT '',
);

