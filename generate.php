<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

// Find all entity files in src/Entity directory
$finder = new Finder();
$finder->in('src/Entity')->files()->name('*.php');

// Loop through each entity file
foreach ($finder as $file) {
    // Get entity class name
    $entityClassName = str_replace('.php', '', $file->getFilename());
    
    // Generate repository file path
    $repositoryFilePath = 'src/Repository/' . $entityClassName . 'Repository.php';

    // Check if the repository file already exists
    if (!file_exists($repositoryFilePath)) {
        // Generate repository for the entity
        $repositoryContent = <<<EOF
<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use App\Entity\\$entityClassName;

class ${entityClassName}Repository extends EntityRepository
{
    // Custom repository methods
}
EOF;

        // Write repository content to the file
        $filesystem = new Filesystem();
        $filesystem->dumpFile($repositoryFilePath, $repositoryContent);

        echo "Repository created for $entityClassName entity.\n";
    } else {
        echo "Repository already exists for $entityClassName entity.\n";
    }
}
