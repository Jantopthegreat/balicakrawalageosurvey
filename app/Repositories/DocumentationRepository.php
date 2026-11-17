<?php

namespace App\Repositories;


class DocumentationRepository
{
    /**
     * Homepage documentation section data.
     */
    public function homePreview(): array
    {
        return [
            // Section background image
            'background_image' => 'images/documentation/background/documentation-bg.jpg',

            // Bottom section description
            'description' => '“To become a trusted Survey and Mapping Consulting Company and Serve with Our Heart”',

            // Video documentation
            'videos' => [
                [
                    'id' => 'survey-video',
                    'title' => 'Dokumentasi Kegiatan Survey',
                    'description' => 'We believe that accuracy is the foundation of every successful project. Therefore, we continuously uphold the highest standards of quality, integrity, safety, and responsibility in every task we undertake. Our commitment is not only to meet our clients   expectations but also to exceed them through innovative approaches, effective collaboration, and outstanding service.',
                    'video_path' => 'videos/video-documentation.mp4',
                    'embed_url' => null,
                ],
                [
                    'id' => 'mapping-video',
                    'title' => 'Dokumentasi Kegiatan Mapping',
                    'description' => 'At Bali Cakrawala Geosurvey, we see every project as an opportunity to create value, build trust, and contribute to sustainable development. We aspire to become a trusted geospatial partner, not only in Bali but also throughout Indonesia and beyond.',
                    'video_path' => 'videos/video-documentation.mp4',
                    'embed_url' => null,
                ],
            ],

            // Photo documentation galleries
            'galleries' => [
                'survey' => [
                    'title' => 'Survey Activities',

                    'photos' => [
                        [
                            'image' => 'images/documentation/survey/survey-01.jpg',
                            'alt' => 'Kegiatan pengukuran survei lapangan',
                        ],
                        [
                            'image' => 'images/documentation/survey/survey-02.jpg',
                            'alt' => 'Dokumentasi kegiatan survei proyek',
                        ],
                        [
                            'image' => 'images/documentation/survey/survey-03.jpg',
                            'alt' => 'Tim melakukan kegiatan survei',
                        ],
                    ],
                ],

                'drone' => [
                    'title' => 'Drone Activities',

                    'photos' => [
                        [
                            'image' => 'images/documentation/drone/drone-01.jpg',
                            'alt' => 'Dokumentasi kegiatan drone',
                        ],
                        [
                            'image' => 'images/documentation/drone/drone-02.jpg',
                            'alt' => 'Persiapan drone untuk pemetaan',
                        ],
                        [
                            'image' => 'images/documentation/drone/drone-03.jpg',
                            'alt' => 'Kegiatan pengambilan data menggunakan drone',
                        ],
                        [
                            'image' => 'images/documentation/drone/drone-04.jpg',
                            'alt' => 'Dokumentasi hasil kegiatan drone',
                        ],
                    ],
                ],
            ],
        ];
    }
}
