{ldelim}
    "image_url": {$result.original|ezroot()},
    "thumbnail_url": {$result.thumbnail|ezroot()},
    "key": "{$result.key}",
    "image_id": "{$result.image_id}",
    "history_version": "{$result.history_version}",
    "image_version": "{$result.image_version}",
    "module_url":   {$result.module_path|ezurl()},
    "image_width": {$result.image_width},
    "image_height": {$result.image_height}
{rdelim}
/* <!--DEBUG_REPORT--> */
