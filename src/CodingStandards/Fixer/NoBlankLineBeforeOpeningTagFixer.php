<?php

namespace Ubitransport\CodingStandards\Fixer;

use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\Utils;

final class NoBlankLineBeforeOpeningTagFixer implements FixerInterface
{
    /**
     * @codeCoverageIgnore
     */
    public function getName(): string
    {
        $nameParts = explode('\\', self::class);
        $name = substr(end($nameParts), 0, -\strlen('Fixer'));

        return 'Ubitransport/'.Utils::camelCaseToUnderscore($name);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'Blank line should not precede PHP opening tag "<?php"',
            [
                new CodeSample(
                    '
                    <?php
                    '
                ),
            ]
        );
    }

    /**
     * @codeCoverageIgnore
     */
    public function isRisky(): bool
    {
        return false;
    }

    public function supports(\SplFileInfo $file): bool
    {
        return 'php' === $file->getExtension();
    }

    /**
     * @codeCoverageIgnore
     */
    public function getPriority(): int
    {
        return 0;
    }

    public function isCandidate(Tokens $tokens): bool
    {
        return !$tokens->isMonolithicPhp();
    }

    public function fix(\SplFileInfo $file, Tokens $tokens): void
    {
        for ($index = 1, $limit = count($tokens); $index < $limit; ++$index) {
            /** @var Token $token */
            $token = $tokens[$index];

            if (!$token->isGivenKind(T_OPEN_TAG)) {
                continue;
            }
            $tokens->clearAt($index - 1);
        }
    }
}
