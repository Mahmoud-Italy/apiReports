<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($rows as $row)
        <url>
            <loc>{{ url($row->slug) }}</loc>
            <lastmod>{{ \Carbon\Carbon::parse($row->timestamp)->timezone('UTC')->toAtomString() }}</lastmod>
            <priority>0.9</priority>
        </url>
    @endforeach
</urlset>