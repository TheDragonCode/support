<?php

namespace DragonCode\SupportDev\Console;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\SupportDev\Dto\PathDto;
use DragonCode\SupportDev\Processors\Helper;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{
    protected string $base_path = __DIR__ . '/../../src';

    protected string $docs_path = __DIR__ . '/../../docs';

    protected function configure()
    {
        $this
            ->setName('generate')
            ->setDescription('Generate docs');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->prepare($output);
        $this->generateHelpers($output);

        return 0;
    }

    protected function prepare(OutputInterface $output): void
    {
        $output->writeln('Prepare docs generating...');

        Directory::ensureDelete($this->docs_path);
    }

    protected function generateHelpers(OutputInterface $output): void
    {
        foreach ($this->files() as $file) {
            $output->writeln('Processing file ' . $file . '...');

            $dto = $this->dto($file);

            $path = $this->targetPath($dto->dirname(), $dto->filename());

            $content = $this->getContent($dto->source(), $dto->header());

            $this->store($path, $content);
        }
    }

    protected function store(string $path, string $content): void
    {
        File::store($path, $content);
    }

    protected function getContent(string $path, string $header): string
    {
        return Helper::make($path, $header)->get();
    }

    #[Pure]
    protected function dto(string $file): PathDto
    {
        return new PathDto($this->base_path, $file);
    }

    protected function files(): array
    {
        return File::names($this->base_path, static fn ($path) => ! Str::startsWith($path, ['Concerns', 'Exceptions', 'Facades']), true);
    }

    protected function targetPath(string $directory, string $filename): string
    {
        return Str::of($this->docs_path)
            ->end('/')
            ->append(Str::lower($directory))
            ->append('/')
            ->append(Str::lower($filename))
            ->append('.md');
    }
}
