<?php

namespace Tests\PhpGeneratorBundle;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Filesystem\Filesystem;
use Tests\TestKernel;

class GenerateRestClientCommandTest extends KernelTestCase
{
    static $class = TestKernel::class;

    /**
     * @var CommandTester
     */
    private $commandTester;

    /**
     * @var Filesystem
     */
    private $filesystem;

    protected function setUp()
    {
        /** @var TestKernel $kernel */
        $kernel = self::createKernel();
        $kernel->setContainerModifier(function (Container $container) {
            $container->setParameter('vendor_prefix', 'vendor');
            $container->setParameter('paysera_code_generator.raml_dir', __DIR__ . '/Fixtures/raml');
            $container->setParameter('paysera_code_generator.output_dir', __DIR__ . '/Fixtures/generated');
        });
        $kernel->boot();

        $container = $kernel->getContainer();
        $application = new Application($kernel);

        $commandInstance = $container->get('paysera_php_generator.command.generate_rest_client');
        $application->add($commandInstance);

        $this->filesystem = $container->get('filesystem');
        $this->commandTester = new CommandTester($commandInstance);

        $kernel->shutdown();
    }

    /**
     * @dataProvider dataProviderTestGenerateCode
     *
     * @param string $apiName
     */
    public function testGenerateCode($apiName)
    {
        $this->commandTester->execute([
            'api_name' => $apiName,
            'namespace' => 'Paysera\\Test\\TestClient'
        ]);

        $this->ensureDirectoryTreeMatches($apiName);
    }

    public function dataProviderTestGenerateCode()
    {
        return [
            ['account'],
            ['category'],
            ['transfer'],
        ];
    }

    /**
     * @param string $apiName
     */
    private function ensureDirectoryTreeMatches($apiName)
    {
        $generatedDir = __DIR__ . '/Fixtures/generated/' . $apiName;
        if (!$this->filesystem->exists($generatedDir)) {
            $this->fail(sprintf('Expected output directory "%s" not found', $generatedDir));
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                __DIR__ . '/Fixtures/expected/' . $apiName,
                \RecursiveDirectoryIterator::SKIP_DOTS
            ),
            \RecursiveIteratorIterator::SELF_FIRST,
            \RecursiveIteratorIterator::CATCH_GET_CHILD
        );

        foreach ($iterator as $item) {
            /** @var $item \SplFileInfo */
            $expected = str_replace('/expected/', '/generated/', $item->getPathname());
            $this->assertFileExists($expected);
            if ($item->isFile()) {
                $expectedContents = file_get_contents($item->getPathname());
                $actualContents = file_get_contents($expected);

                $this->assertEquals(
                    $expectedContents,
                    $actualContents,
                    sprintf('Contents are different for file "%s"', $item->getBasename())
                );
            }
        }
    }
}
