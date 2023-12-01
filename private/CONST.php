<?php
const REGEXP_TITLE_FILTER = "/[^a-zA-Z0-9 _'àèéìòùAÈÉÌÒÙ]/";
const REGEXP_CONTENT_FILTER = "/[^a-zA-Z0-9_\"` '\\-\n|àèéìòùAÈÉÌÒÙ?!@+*#\[\]\.\(\):,;\/]/";
const REGEXP_TITLE_EXTRACT = "/title\s*=\s*\"([a-zA-Z0-9 _'àèéìòùAÈÉÌÒÙ]+)\"/";

const REGEXP_IMG_NAME_EXTRACT = "/^([a-z0-9_]+)\.(png|jpg)$/";
const REGEXP_PATH_QUERYSTRING = "/[^a-z0-9_|?]/";

const SITE_NAME = "Fablab Wiki";
// const SITE_URL = "/testwiki";
const SITE_URL = "";
?>