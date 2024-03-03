<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\API\DTO\AbstractDTO;
use PHPUnit\Framework\TestCase;

class AbstractDTOTest extends TestCase
{
    public function testToArray(): void
    {
        $dto = $this->createDTO();

        $this->assertEquals([
            'id' => '123',
            'name' => 'Test',
            'arrayOfAbstractDTOs' => [
                ['id' => 1, 'name' => 'Item 1'],
                ['id' => 2, 'name' => 'Item 2'],
            ],
            'abstractDTO' => [
                'id' => '123',
                'name' => 'Test',
            ],
        ], $dto->toArray());
    }

    public function testToArrayWithEmptyArray(): void
    {
        $dto = new class extends AbstractDTO {
            /**
             * @return mixed[]
             */
            public function toArray(): array
            {
                return [];
            }
        };

        $this->assertEquals([], $dto->toArray());
    }

    private function createDTO(): AbstractDTO
    {
        return new class extends AbstractDTO {
            private string $id = '123';
            private string $name = 'Test';

            public function getId(): string
            {
                return $this->id;
            }

            public function getName(): string
            {
                return $this->name;
            }

            /**
             * @return AbstractDTO[]
             */
            public function getArrayOfAbstractDTOs(): array
            {
                $items = [
                    ['id' => 1, 'name' => 'Item 1'],
                    ['id' => 2, 'name' => 'Item 2'],
                ];

                return array_map(fn($item) => new class ($item) extends AbstractDTO {
                    private int $id;
                    private string $name;

                    public function __construct(array $item)
                    {
                        $this->id = $item['id'];
                        $this->name = $item['name'];
                    }

                    public function getId(): int
                    {
                        return $this->id;
                    }

                    public function getName(): string
                    {
                        return $this->name;
                    }
                }, $items);
            }

            public function getAbstractDTO(): AbstractDTO
            {
                return new class extends AbstractDTO {
                    private string $id = '123';
                    private string $name = 'Test';

                    public function getId(): string
                    {
                        return $this->id;
                    }

                    public function getName(): string
                    {
                        return $this->name;
                    }
                };
            }
        };
    }
}
