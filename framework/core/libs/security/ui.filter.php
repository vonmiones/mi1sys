<?php
function StripQuoteTags($value) {
	// filter_input(INPUT_GET, 'input', FILTER_SANITIZE_SPECIAL_CHARS)
	return htmlspecialchars(strip_tags($value),ENT_QUOTES, 'UTF-8');
}
function FilterQuoteTags($value) {
	// filter_input(INPUT_GET, 'input', FILTER_SANITIZE_SPECIAL_CHARS)
	// return htmlspecialchars(strip_tags($value),ENT_QUOTES, 'UTF-8');
	return filter_input(INPUT_GET, $value, FILTER_SANITIZE_SPECIAL_CHARS);
}
