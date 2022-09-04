<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220616035745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $users = $schema->createTable('users');

        $users->addColumn('id', 'integer',['unsigned'=>true])->setAutoincrement(true);
        $users->addColumn('name', Types::STRING,);
        $users->addColumn('email', Types::STRING);
        $users->addColumn('phone', Types::STRING);
        $users->addColumn('password', Types::STRING);
        $users->addUniqueIndex(['email']);
        $users->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('users');
    }
}
