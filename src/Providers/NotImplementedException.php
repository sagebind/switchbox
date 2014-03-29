<?php
namespace Switchbox\Providers;

use BadMethodCallException;
use Switchbox\Exception;

/**
 * Exception thrown when an operation is not supported by a settings provider.
 */
class NotImplementedException extends BadMethodCallException implements Exception
{}
