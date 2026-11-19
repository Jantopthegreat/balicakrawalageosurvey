<?php

namespace App\Repositories;

/**
 * Temporary content source for static pages.
 * Replace these methods with API-backed data when the client API is ready.
 */
class PageContentRepository
{
    public function homeHero(): array
    {
        return [
            'eyebrow' => 'Welcome to Cakrawala Geosurvey',
            'title' => 'Welcome to Cakrawala Geosurvey',
            'subtitle' => 'Cakrawala Geosurvey.',
            'description' => 'Bali Cakrawala Geosurvey strives to be the Best and Leading Surveying and Mapping Company in Bali. A professional geospatial company committed to delivering excellence in surveying, mapping, and geospatial solutions. We are committed to providing reliable, accurate, and high-quality services that support infrastructure development, land management, construction, engineering, and various geospatial projects.',
            'image' => 'images/hero/herolandscape.png',
            'feature' => [
                'image' => 'images/hero/hero-feature-placeholder.svg',
                'title' => 'Accurate Data for Every Project',
                'description' => 'Modern mapping solutions to support analysis, planning, and better decision-making.',
            ],
        ];
    }

    public function homeCallToAction(): array
    {
        return [
            'eyebrow' => 'HAVE A PROJECT IN MIND?',
            'title' => 'Let’s map out your next project.',
            'description' => 'Talk with our team about your surveying, mapping, or spatial-data requirements.',
        ];
    }
}
