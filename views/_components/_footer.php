<?php
  $footer_data = [
    [
      'heading' => 'Santia-Go Partners',
      'links' => [
        [
          'title' => 'To courier partners',
          'href' => '#0'
        ],
        [
          'title' => 'To restaurants',
          'href' => '#0'
        ],
        [
          'title' => 'To Shops',
          'href' => '#0'
        ],
      ]
    ],
    [
      'heading' => 'Company',
      'links' => [
        [
          'title' => 'About Us',
          'href' => '#0'
        ],
        [
          'title' => 'What we stand for',
          'href' => '#0'
        ],
        [
          'title' => 'Jobs',
          'href' => '#0'
        ],
        [
          'title' => 'Accountability',
          'href' => '#0'
        ],
        [
          'title' => 'Security',
          'href' => '#0'
        ],
        [
          'title' => 'Investors',
          'href' => '#0'
        ],
      ]
    ],
    [
      'heading' => 'Useful links',
      'links' => [
        [
          'title' => 'Support',
          'href' => '#0'
        ],
        [
          'title' => 'Media',
          'href' => '#0'
        ],
        [
          'title' => 'Contact',
          'href' => '#0'
        ],
        [
          'title' => 'Speak up',
          'href' => '#0'
        ],
        [
          'title' => 'Promocodes',
          'href' => '#0'
        ],
        [
          'title' => 'Developers',
          'href' => '#0'
        ],
      ]
    ],
    [
      'heading' => 'Products',
      'links' => [
        [
          'title' => 'Til kurérpartnere',
          'href' => '#0'
        ],
        [
          'title' => 'Santia-Go Drive',
          'href' => '#0'
        ],
        [
          'title' => 'Santia-Go Market',
          'href' => '#0'
        ],
        [
          'title' => 'Santia-Go+',
          'href' => '#0'
        ],
        [
          'title' => 'Santia-Go for Work',
          'href' => '#0'
        ],
      ]
    ],
    [
      'heading' => 'Follow us',
      'links' => [
        [
          'title' => 'Blog',
          'href' => '#0'
        ],
        [
          'title' => 'Development blog',
          'href' => '#0'
        ],
        [
          'title' => 'Instagram',
          'href' => '#0'
        ],
        [
          'title' => 'Facebook',
          'href' => '#0'
        ],
        [
          'title' => 'Twitter',
          'href' => '#0'
        ],
        [
          'title' => 'LinkedIn',
          'href' => '#0'
        ],
        [
          'title' => 'Santia-Go Life',
          'href' => '#0'
        ],
      ]
    ],
  ]
?>

  <footer class="relative w-full bg-top bg-no-repeat bg-x-full bg-gradient-primary-reverse mt-40 after:content-[''] after:bg-wave-pattern after:absolute after:w-full after:h-20 md:after:h-40 after:-top-10 after:bg-stretch after:-z-10">
    <section class="max-w-8xl p-4 mx-auto mt-auto flex w-full justify-between flex-wrap">
      <?php foreach($footer_data as $column): ?>
      <article class="w-1/2 md:w-1/3 lg:w-1/6 px-2 py-6">
        <h3 class="text-lg font-semibold text-off-white mb-2"><?= $column['heading'] ?></h3>
        <ul class="flex flex-col gap-1">
          <?php foreach($column['links'] as $link): ?>
          <li class="block"><a href="<?= $link['href'] ?>" class="text-off-white hover:underline font-medium"><?= $link['title'] ?></a></li>
          <?php endforeach ?>
        </ul>
      </article>
      <?php endforeach ?>
    </section>
  </footer>

  </body>
</html>